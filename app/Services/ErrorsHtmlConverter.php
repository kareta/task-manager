<?php

namespace Services;


class ErrorsHtmlConverter
{
    /**
     * @param array $errors
     * @return string
     */
    public function convert($errors)
    {
        $output = '<ul class="list-unstyled text-danger task-errors">';
        foreach ($errors as $error) {
            $output .= '<li>' . $error . '</li>';
        }
        return $output . '</ul>';
    }
}