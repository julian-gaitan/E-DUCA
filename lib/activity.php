<?php

include_once 'orm.php';

class Activity extends ORM {

    protected int $id;
    protected int $fk_module;
    protected int $index;
    protected string $title;
    protected int $type;
    public const TABLE_NAME = 'tbl_actividades';
    public const FIELDS_MAP = [
        'id' => 'id',
        'fk_module' => 'fk_modulo',
        'index' => 'indice',
        'title' => 'titulo',
        'type' => 'tipo',
    ];
    public const INPUTS_MAP = [
        'id' => 'id',
        'fk-module' => 'fk_modulo',
        'index' => 'indice',
        'title' => 'titulo',
        'content' => '',
    ];

    function __construct() {
        $this->table_name = self::TABLE_NAME;
        $this->fields_map = self::FIELDS_MAP;
        $this->id = 0;
        $this->fk_module = 0;
        $this->index = 0;
        $this->title = "";
        $this->type = 0;
    }

    protected function newObj() {
        return new Activity();
    }

    public function get_id(): int {
        return $this->id;
    }

    public function set_id(int $id): void {
        if (is_null($id)) return;
        $this->id = $id;
    }
    
    public function get_fk_module(): int {
        return $this->fk_module;
    }

    public function set_fk_module(int $fk_module): void {
        if (is_null($fk_module)) return;
        $this->fk_module = $fk_module;
    }
    
    public function get_index(): int {
        return $this->index;
    }

    public function set_index(int $index): void {
        if (is_null($index)) return;
        $this->index = $index;
    }
    
    public function get_title(): string {
        return $this->title;
    }

    public function set_title(string $title): void {
        if (is_null($title)) return;
        $this->title = $title;
    }
    
    public function get_type(): string {
        return $this->type;
    }

    public function set_type(string $type): void {
        if (is_null($type)) return;
        $this->type = $type;
    }

}