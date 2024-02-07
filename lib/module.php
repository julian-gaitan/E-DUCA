<?php

include_once 'orm.php';

class Module extends ORM {

    protected int $id;
    protected int $fk_course;
    protected int $index;
    protected string $title;
    protected string $subject;
    public const TABLE_NAME = 'tbl_modulos';
    public const FIELDS_MAP = [
        'id' => 'id',
        'fk_course' => 'fk_curso',
        'index' => 'indice',
        'title' => 'titulo',
        'subject' => 'asignatura',
    ];
    public const INPUTS_MAP = [
        'id' => 'id',
        'fk-course' => 'fk_curso',
        'index' => 'indice',
        'title' => 'titulo',
        'content' => '',
    ];

    function __construct() {
        $this->table_name = self::TABLE_NAME;
        $this->fields_map = self::FIELDS_MAP;
        $this->id = 0;
        $this->fk_course = 0;
        $this->index = 0;
        $this->title = "";
        $this->subject = "";
    }

    protected function newObj() {
        return new Module();
    }

    public function get_id(): int {
        return $this->id;
    }

    public function set_id(int $id): void {
        if (is_null($id)) return;
        $this->id = $id;
    }
    
    public function get_fk_course(): int {
        return $this->fk_course;
    }

    public function set_fk_course(int $fk_course): void {
        if (is_null($fk_course)) return;
        $this->fk_course = $fk_course;
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
    
    public function get_subject(): string {
        return $this->subject;
    }

    public function set_subject(string $subject): void {
        if (is_null($subject)) return;
        $this->subject = $subject;
    }

}