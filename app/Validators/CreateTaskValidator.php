<?php

namespace Validators;


use Core\Http\Request;
use Core\Validator;

class CreateTaskValidator implements Validator
{

    /**
     * @param Request $request
     * @return array
     */
    public function validate(Request $request)
    {
        $errors = [];

        $username = $request->input('username');
        $email = $request->input('email');
        $content = $request->input('content');
        $content = trim($content);

        if (!preg_match('/^[A-Za-z0-9_-]{3,15}$/', $username)) {
            $errors[] = 'Username is incorrect';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email is incorrect';
        }

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


