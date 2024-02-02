<?php

include_once 'orm.php';

class Course extends ORM {

    protected int $id;
    protected int $fk_teacher;
    protected string $name;
    protected string $description;
    protected string $content_list;
    protected string $category_list;
    protected string $tags;
    protected string $folder;
    public const TABLE_NAME = 'tbl_cursos';
    public const FIELDS_MAP = [
        'id' => 'id',
        'fk_teacher' => 'fk_profesor',
        'name' => 'nombre',
        'description' => 'descripcion',
        'content_list' => 'lista_contenido',
        'category_list' => 'lista_categoria',
        'tags' => 'tags',
        'folder' => 'carpeta',
    ];
    public const INPUTS_MAP = [
        'id' => 'id',
        'teacher' => 'fk_profesor',
        'name' => 'nombre',
        'description' => 'descripcion',
        'content-list' => 'lista_contenido',
        'category-list' => 'lista_categoria',
        'tags' => 'tags',
        'folder' => 'carpeta',
    ];

    function __construct() {
        $this->table_name = self::TABLE_NAME;
        $this->fields_map = self::FIELDS_MAP;
        $this->id = 0;
        $this->fk_teacher = 0;
        $this->name = "";
        $this->description = "";
        $this->content_list = "";
        $this->category_list = "";
        $this->tags = "";
        $this->folder = "";
    }

    protected function newObj() {
        return new Course();
    }

    public function get_id(): int {
        return $this->id;
    }

    public function set_id(int $id): void {
        if (is_null($id)) return;
        $this->id = $id;
    }

    public function get_fk_teacher(): int {
        return $this->fk_teacher;
    }

    public function set_fk_teacher(int $fk_teacher): void {
        if (is_null($fk_teacher)) return;
        $this->fk_teacher = $fk_teacher;
    }

    public function get_name(): string {
        return $this->name;
    }

    public function set_name(string $name): void {
        if (is_null($name)) return;
        $this->name = $name;
    }

    public function get_description(): string {
        return $this->description;
    }

    public function set_description(string $description): void {
        if (is_null($description)) return;
        $this->description = $description;
    }

    public function get_content_list(): string {
        return $this->content_list;
    }

    public function set_content_list(string $content_list): void {
        if (is_null($content_list)) return;
        $this->content_list = $content_list;
    }

    public function get_category_list(): string {
        return $this->category_list;
    }

    public function set_category_list(string $category): void {
        if (is_null($category)) return;
        $this->category_list = $category;
    }

    public function get_tags(): string {
        return $this->tags;
    }

    public function set_tags(string $tags): void {
        if (is_null($tags)) return;
        $this->tags = $tags;
    }

    public function get_folder(): string {
        return $this->folder;
    }

    public function set_folder(string $folder): void {
        if (is_null($folder)) return;
        $this->folder = $folder;
    }

}