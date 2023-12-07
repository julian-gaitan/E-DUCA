<?php

include_once 'orm.php';

class Role extends ORM {

    protected int $id;
    protected int $value;
    protected string $type;
    protected string $pages;
    protected string $table;
    public const TABLE_NAME = 'tbl_roles';
    public const FIELDS_MAP = [
        'id' => 'id',
        'value' => 'valor',
        'type' => 'tipo',
        'pages' => 'paginas',
        'table' => 'tabla',
    ];
    public const INPUTS_MAP = [
    ];

    function __construct() {
        $this->table_name = self::TABLE_NAME;
        $this->fields_map = self::FIELDS_MAP;
        $this->id = 0;
        $this->value = 0;
        $this->type = "";
        $this->pages = "";
        $this->table = "";
    }

    protected function newObj() {
        return new Role();
    }

    public function get_id(): int {
        return $this->id;
    }

    public function set_id(int $id): void {
        if (is_null($id)) return;
        $this->id = $id;
    }

    public function get_value(): int {
        return $this->value;
    }

    public function set_value(int $value): void {
        if (is_null($value)) return;
        $this->value = $value;
    }

    public function get_type(): string {
        return $this->type;
    }

    public function set_type(string $type): void {
        if (is_null($type)) return;
        $this->type = $type;
    }

    public function get_pages(): string {
        return $this->pages;
    }

    public function set_pages(string $pages): void {
        if (is_null($pages)) return;
        $this->pages = $pages;
    }

    public function get_table(): string {
        return $this->table;
    }

    public function set_table(string $table): void {
        if (is_null($table)) return;
        $this->table = $table;
    }
}