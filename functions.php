<?php

/**
 * Trim whitespace and strip tags from data
 * 
 * @param array $data form data
 * @param array $allowedData allowed fields
 * @return array
 */
function filterData($data, $allowedData)
{
    foreach ($data as $key => $value) {
        if (!in_array($key, $allowedData)) {
            unset($data[$key]);
            continue;
        }

        $data[$key] = trim(strip_tags($value));
    }

    return $data;
}

/**
 * Validate form data
 * 
 * @param array $data form data
 * @param array $rules validation rules
 * @return array $errors
 */
function validate($data, $rules)
{
    $errors = [];

    foreach ($data as $key => $value) {
        switch ($rules[$key]) {
            case 'required':
                if (empty($value)) {
                    $errors[$key] = sprintf('%s is required', $key);                    
                }
                break;
            case 'number':
                if (!is_numeric($value)) {
                    $errors[$key] = sprintf('%s must be a number', $key);
                }
                break;
            case 'email':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$key] = 'Email is not valid';
                }
                break;
            case 'phone':
                if (!preg_match('/^\+421[0-9]{9}/', $value)) {
                    $errors[$key] = 'Phone is not valid';
                }
        }        
    }

    return $errors;
}
