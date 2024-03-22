<?php

include_once 'orm.php';

class Response extends ORM {

    protected int $id;
    protected int $fk_forum;
    protected int $fk_author;
    protected string $response;
    protected string $created_at;
    protected string $updated_at;
    public const TABLE_NAME = 'tbl_respuestas';
    public const FIELDS_MAP = [
        'id' => 'id',
        'fk_forum' => 'fk_foro',
        'fk_author' => 'fk_autor',
        'response' => 'respuesta',
        'created_at' => 'created_at',
        'updated_at' => 'updated_at',
    ];
    public const INPUTS_MAP = [
        'id' => 'id',
        'fk-forum' => 'fk_foro',
        'fk-author' => 'fk_autor',
        'response' => 'respuesta',
    ];

    function __construct() {
        $this->table_name = self::TABLE_NAME;
        $this->fields_map = self::FIELDS_MAP;
        $this->id = 0;
        $this->fk_forum = 0;
        $this->fk_author = 0;
        $this->response = "";
        $this->created_at = "";
        $this->updated_at = "";
    }

    protected function newObj() {
        return new Response();
    }

    public function get_id(): int {
        return $this->id;
    }

    public function set_id(int $id): void {
        if (is_null($id)) return;
        $this->id = $id;
    }

    public function get_fk_forum(): int {
        return $this->fk_forum;
    }

    public function set_fk_forum(int $fk_forum): void {
        if (is_null($fk_forum)) return;
        $this->fk_forum = $fk_forum;
    }

    public function get_fk_author(): int {
        return $this->fk_author;
    }

    public function set_fk_author(int $fk_author): void {
        if (is_null($fk_author)) return;
        $this->fk_author = $fk_author;
    }

    public function get_response(): string {
        return $this->response;
    }

    public function set_response(string $response): void {
        if (is_null($response)) return;
        $this->response = $response;
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