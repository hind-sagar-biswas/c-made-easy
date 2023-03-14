<?php

class Contr
{
    protected $DEBUG = False;
    protected $fileUpSize = 2; // in MB

    public function upload_image(string $fileKey): array
    {
        // Check if post request
        if ($_SERVER["REQUEST_METHOD"] != "POST") return ["error" => true, "response" => "Not a valid Upload request!"];

        // Check if file was uploaded without errors
        if (!isset($_FILES[$fileKey]) || $_FILES[$fileKey]["error"] != 0) return ["error" => true, "response" => $_FILES[$fileKey]["error"]];

        $uploadDIR = __DIR__ . "/../../assets/images/uploads/";
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $name = date("Ymd_His_") . $_FILES[$fileKey]["name"];
        $type = $_FILES[$fileKey]["type"];
        $size = $_FILES[$fileKey]["size"];

        $response = [
            "error" => false,
            "name" => $name,
            "response" => "File uploaded successfully!"
        ];

        // Verify file extension
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed)) return ["error" => true, "response" => "Please select a valid file format."];

        // Verify file size - 2MB maximum
        $maxsize = $this->fileUpSize * 1024 * 1024;
        if ($size > $maxsize) return ["error" => true, "response" => "File size is larger than the allowed limit."];

        // Verify MYME type of the file
        if (!in_array($type, $allowed)) return ["error" => true, "response" => "There was a problem uploading your file. Please try again."];

        // Check whether file exists before uploading it
        if (file_exists($uploadDIR . $name)) return ["error" => true, "response" => $name . " is already exists."];

        move_uploaded_file($_FILES[$fileKey]["tmp_name"],  $uploadDIR . $name);
        return $response;
    }

    protected function setCookie(string $name, $value, int $expiry = 30): void
    {
        setcookie($name, $value, $expiry, '/');
    }
}
