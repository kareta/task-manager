<?php

namespace Validators;


use Core\Http\Request;
use Core\Validator;

class EditTaskValidator implements Validator
{

    /**
     * @param Request $request
     * @return array
     */
    public function validate(Request $request)
    {
        $errors = [];

        $content = $request->input('content');
        $content = trim($content);

        if (empty($content)) {
            $errors[] = 'Content is not allowed to be empty';
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $path = $image['name'];
            $extension = pathinfo($path, PATHINFO_EXTENSION);

            if (!in_array($extension, ['jpeg', 'jpg', 'png', 'gif'])) {
                $errors[] = "$extension is not allowed image format. Allowed formats are jpeg/png/gif";
            }
        }

        return $errors;
    }
}