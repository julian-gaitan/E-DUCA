<?php

include_once 'orm.php';

class Student extends ORM {

    protected int $id;
    protected string $affiliation;
    public const TABLE_NAME = 'tbl_estudiantes';
    public const FIELDS_MAP = [
        'id' => 'id',
        'affiliation' => 'afiliacion',
    ];
    public const INPUTS_MAP = [
        'id' => 'id',
    ];

    function __construct() {
        $this->table_name = self::TABLE_NAME;
        $this->fields_map = self::FIELDS_MAP;
        $this->id = 0;
        $this->affiliation = "";
    }

    protected function newObj() {
        return new Student();
    }

    public function get_id(): int {
        return $this->id;
    }

    public function set_id(int $id): void {
        if (is_null($id)) return;
        $this->id = $id;
    }

    public function get_affiliation(): string {
        return $this->affiliation;
    }

    public function set_affiliation(string $affiliation): void {
        if (is_null($affiliation)) return;
        $this->affiliation = $affiliation;
    }
}
