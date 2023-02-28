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

    protected function int_echo_format(int $value, string $title = 'DEBUG'): string
    {
        return "
            <div>
                <b style='color: rgb(0, 91, 188)'>$title => </b>
                <span style='color: rgb(253, 27, 114)'>" . $value . "</span>
            </div>
        ";
    }
    public function str_echo_format(string $value, string $title = 'DEBUG'): string
    {
        if (filter_var($value, FILTER_VALIDATE_URL)) $value = "    <a href='$value' target='_blank' rel='noopener noreferrer'>$value</a>";
        return "
            <div>
                <b style='color: rgb(0, 91, 188)'>$title => </b>
                <span style='color: darkgreen'>'" . $value . "'</span>
            </div>
        ";
    }
    protected function bool_echo_format(bool $value, string $title = 'DEBUG'): string
    {
        if ($value === true) $value = "true";
        if ($value === false) $value = "false";
        return "
            <div>
                <b style='color: rgb(0, 91, 188)'>$title => </b>
                <span style='color: rgb(27, 193, 253); font-style: italic;'>" . $value . "</span>
            </div>
        ";
    }
    protected function null_echo_format($value, string $title = 'DEBUG'): string
    {
        if ($value === null) $value = "null";
        return "
            <div>
                <b style='color: rgb(0, 91, 188)'>$title => </b>
                <span style='color: red; font-style: italic;'>" . $value . "</span>
            </div>
        ";
    }

    public function echo_debug(mixed $value, string $title = 'DEBUG')
    {
        if (!$this->DEBUG) return False;
        if ($value === null) echo $this->null_echo_format($value, $title);
        elseif (is_numeric($value)) echo $this->int_echo_format($value, $title);
        elseif (is_bool($value) || $value == "true" || $value == "false") echo $this->bool_echo_format($value, $title);
        elseif (is_string($value)) echo $this->str_echo_format($value, $title);
        elseif (is_array($value)) {

            if (is_numeric($title)) $title = "<font color='darkorange'>$title</font>";

            echo "<div> <b style='color: rgb(0, 91, 188)'>$title => [</b> <br>";
            foreach ($value as $key => $val) {
                $this->echo_debug($val, $key);
            }
            echo " <b style='color: rgb(0, 91, 188)'>]</b> <br> </div>";
        }
    }
}
