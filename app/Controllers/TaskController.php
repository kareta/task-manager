<?php

namespace Controllers;

use Core\Application;
use Core\Controller;
use Core\Exceptions\NotFoundException;
use Core\Http\Request;
use Core\Http\Response;
use Models\Task;
use Services\ErrorsHtmlConverter;
use Services\Images\GdCompressor;
use Services\ImageSaver;
use Services\Paginator;
use Validators\CreateTaskValidator;
use Validators\EditTaskValidator;

class TaskController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->renderTasksList($request, 'task/index');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function tasksList(Request $request)
    {
        return $this->renderTasksList($request, 'task/list');
    }

    /**
     * @param Request $request
     * @param string $viewName
     * @return Response
     */
    public function renderTasksList(Request $request, $viewName)
    {
        $page = (int) $request->input('page', 1);
        $perpage = (int) $request->input('perpage', 3);
        $order = $request->input('order', 'none');

        $orderSql = $order;
        if (!in_array($orderSql, ['username', 'email', 'uncompleted'])) {
            $orderSql = 'id DESC';
        }

        $orderSql  = $order == 'uncompleted first' ? 'completed' : $orderSql;

        $tasks = Task::select("ORDER BY $orderSql LIMIT :perpage OFFSET :page", [
            ':perpage' =>  $perpage,
            ':page' => ($page - 1) * $perpage,
        ]);

        $count = Task::count();

        $paginator = new Paginator("tasks?order=$order&", $page, $perpage, $count);

        return $this->render($viewName, compact(
            'tasks', 'request', 'paginator', 'order'
        ));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function preview(Request $request)
    {
        $errors = (new CreateTaskValidator())->validate($request);
        $html = (new ErrorsHtmlConverter())->convert($errors);

        if (!empty($errors)) {
            return new Response(400, $html);
        }

        $task = new Task();

        if($request->hasFile('image')) {
            $imageSaver = new ImageSaver();
            $path = $imageSaver->save($_FILES['image'], new GdCompressor(320, 240));
            $_SESSION['preview_image'] = basename($path);
            $task->image_path = $_SESSION['preview_image'];
        }

        $task->username = $request->input('username');
        $task->email = $request->input('email');
        $task->content = $request->input('content');
        $task->completed = false;

        return $this->render('task/preview', compact('task'));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $errors = (new CreateTaskValidator())->validate($request);

        if (!empty($errors)) {
            $html = (new ErrorsHtmlConverter())->convert($errors);
            return new Response(400, $html);
        }

        $task = new Task();

        if($request->hasFile('image')) {

            $imageSaver = new ImageSaver();

            $path = $imageSaver->save(
                $_FILES['image'], new GdCompressor(320, 240)
            );

            $task->image_path = basename($path);
        }

        $task->username = $request->input('username');
        $task->email = $request->input('email');
        $task->content = $request->input('content');
        $task->save();

        return $this->renderTasksList($request, 'task/list');
    }

    /**
     * @param Request $request
     * @param string|int $taskId
     * @return Response
     */
    public function getEditable(Request $request, $taskId)
    {
        $task = Task::get($taskId);
        return $this->render('task/editable', compact(
            'task', 'request'
        ));
    }

    /**
     * @param Request $request
     * @param string|int $taskId
     * @return Response
     */
    public function edit(Request $request, $taskId)
    {
        $errors = (new EditTaskValidator())->validate($request);

        if (!empty($errors)) {
            $html = (new ErrorsHtmlConverter())->convert($errors);
            return new Response(400, $html);
        }

        $task = Task::get($taskId);

        if($request->hasFile('image')) {

            $imageSaver = new ImageSaver();
            $path = $imageSaver->save(
                $request->file('image'), new GdCompressor(320, 240)
            );
            $task->image_path = basename($path);
        }

        $task->content = $request->input('content');

        $task->save();

        return $this->render('task/task', compact('task', 'request'));
    }

    /**
     * @param Request $request
     * @param string|int $taskId
     * @return Response
     */
    public function complete(Request $request, $taskId)
    {
        $task = Task::get($taskId);
        $task->completed = true;
        $task->save();

        return $this->render('task/task', compact('task', 'request'));
    }

    /**
     * @param Request $request
     * @param string|int $taskId
     * @return Response
     * @throws NotFoundException
     */
    public function getImage(Request $request, $taskId)
    {
        $task = Task::getOrFail($taskId);
        $imageRealPath = Application::$config['images_path'] . $task->image_path;

        Application::$log->debug($imageRealPath);
        return $this->sendImage($request, $imageRealPath);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function previewImage(Request $request)
    {
        $imageRealPath = Application::$config['images_path'] . $_SESSION['preview_image'];

        $response = $this->sendImage($request, $imageRealPath);

        unlink($imageRealPath);
        unset($_SESSION['preview_image']);

        return $response;
    }

    /**
     * @param Request $request
     * @param string $imageRealPath
     * @return Response
     */
    public function sendImage(Request $request, $imageRealPath)
    {
        if (!file_exists($imageRealPath)) {
            return new Response(404);
        }
        $imageContent = file_get_contents($imageRealPath);

        $extension = pathinfo($imageRealPath, PATHINFO_EXTENSION);
        $response = new Response(200, $imageContent);
        $response->addHeader('Content-Type', 'image/' . $extension);
        $response->addHeader('Content-Length',  filesize($imageRealPath));
        return $response;
    }
}