<?php

include_once 'orm.php';

class Teacher extends ORM {

    protected int $id;
    protected string $title;
    public const TABLE_NAME = 'tbl_profesores';
    public const FIELDS_MAP = [
        'id' => 'id',
        'title' => 'titulo',
    ];
    public const INPUTS_MAP = [
        'id' => 'id',
    ];

    function __construct() {
        $this->table_name = self::TABLE_NAME;
        $this->fields_map = self::FIELDS_MAP;
        $this->id = 0;
        $this->title = "";
    }

    protected function newObj() {
        return new Teacher();
    }

    public function get_id(): int {
        return $this->id;
    }

    public function set_id(int $id): void {
        if (is_null($id)) return;
        $this->id = $id;
    }

    public function get_title(): string {
        return $this->title;
    }

    public function set_title(string $title): void {
        if (is_null($title)) return;
        $this->title = $title;
    }
}
