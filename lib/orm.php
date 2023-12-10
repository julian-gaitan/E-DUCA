<?php

include_once "util.php";

class ORM {
    protected string $table_name;
    protected array $fields_map;

    protected function valuesMap(): string {
        return implode(", ", array_values($this->fields_map));
    }

    public static function findbyId(PDO $conn, object $ref_obj, int $id): object {
        $new_obj = call_user_func([$ref_obj, "newObj"]);
        try {
            $sql = 'SELECT ' . $ref_obj->valuesMap() . ' FROM ' . $ref_obj->table_name . ' WHERE ' . $ref_obj->fields_map['id'] . '=' . $id;
            $stmt = $conn->query($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            if (count($result) > 0) {
                $result = $result[0];
                $new_obj = call_user_func([$ref_obj, "newObj"]);
                foreach ($ref_obj->fields_map as $key => $value) {
                    call_user_func([$new_obj, "set_" . $key], $result[$value]);
                }
            }
        } catch (Exception $ex) {
            $new_obj = call_user_func([$ref_obj, "newObj"]);
            console_log($ex->getMessage());
        }
        return $new_obj;
    }

    public static function findAll(PDO $conn, object $ref_obj): array {
        $new_array = [];
        try {
            $sql = 'SELECT ' . $ref_obj->valuesMap() . ' FROM ' . $ref_obj->table_name;
            $stmt = $conn->query($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            for ($i = 0; $i < count($result); $i++) {
                $new_obj = call_user_func([$ref_obj, "newObj"]);
                foreach ($ref_obj->fields_map as $key => $value) {
                    call_user_func([$new_obj, "set_" . $key], $result[$i][$value]);
                }
                $new_array[] = $new_obj;
            }
        } catch (Exception $ex) {
            $new_array = [];
            console_log($ex->getMessage());
        }
        return $new_array;
    }
}