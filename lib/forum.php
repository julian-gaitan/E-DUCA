<?php

include_once 'orm.php';

class Forum extends ORM {

    protected int $id;
    protected int $fk_course;
    protected int $fk_author;
    protected string $title;
    protected string $content;
    protected bool $state;
    protected string $created_at;
    protected string $updated_at;
    public const TABLE_NAME = 'tbl_foros';
    public const FIELDS_MAP = [
        'id' => 'id',
        'fk_course' => 'fk_curso',
        'fk_author' => 'fk_autor',
        'title' => 'titulo',
        'content' => 'contenido',
        'state' => 'estado',
        'created_at' => 'created_at',
        'updated_at' => 'updated_at',
    ];
    public const INPUTS_MAP = [
        'id' => 'id',
        'fk-course' => 'fk_curso',
        'fk-author' => 'fk_autor',
        'title' => 'titulo',
        'content' => 'contenido',
    ];

    function __construct() {
        $this->table_name = self::TABLE_NAME;
        $this->fields_map = self::FIELDS_MAP;
        $this->id = 0;
        $this->fk_course = 0;
        $this->fk_author = 0;
        $this->title = "";
        $this->content = "";
        $this->state = false;
        $this->created_at = "";
        $this->updated_at = "";
    }

    protected function newObj() {
        return new Forum();
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

    public function get_fk_author(): int {
        return $this->fk_author;
    }

    public function set_fk_author(int $fk_author): void {
        if (is_null($fk_author)) return;
        $this->fk_author = $fk_author;
    }

    public function get_title(): string {
        return $this->title;
    }

    public function set_title(string $title): void {
        if (is_null($title)) return;
        $this->title = $title;
    }

    public function get_content(): string {
        return $this->content;
    }

    public function set_content(string $content): void {
        if (is_null($content)) return;
        $this->content = $content;
    }

    public function get_state(): bool {
        return $this->state;
    }

    public function set_state(bool $state): void {
        if (is_null($state)) return;
        $this->state = $state;
    }

    protected function set_created_at(string $created_at): void {
        if (is_null($created_at)) return;
        $this->created_at = $created_at;
    }

    public function get_created_at(): string {
        return $this->created_at;
    }

    protected function set_updated_at(string $updated_at): void {
        if (is_null($updated_at)) return;
        $this->updated_at = $updated_at;
    }

    public function get_updated_at(): string {
        return $this->updated_at;
    }

}