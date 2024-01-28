<?php

include_once 'orm.php';

class Subscription extends ORM {

    protected int $id;
    protected string $name;
    protected int $users;
    protected int $courses;
    protected string $attention;
    protected string $certificate;
    protected int $price;
    public const TABLE_NAME = 'tbl_suscripciones';
    public const FIELDS_MAP = [
        'id' => 'id',
        'name' => 'nombre',
        'users' => 'usuarios',
        'courses' => 'cursos',
        'attention' => 'atencion',
        'certificate' => 'certificado',
        'price' => 'precio',
    ];
    public const INPUTS_MAP = [
        'id' => 'id',
    ];

    function __construct() {
        $this->table_name = self::TABLE_NAME;
        $this->fields_map = self::FIELDS_MAP;
        $this->id = 0;
        $this->name = "";
        $this->users = 0;
        $this->courses = 0;
        $this->attention = "";
        $this->certificate = "";
        $this->price = 0;
    }

    protected function newObj() {
        return new Subscription();
    }

    public function get_id(): int {
        return $this->id;
    }

    public function set_id(int $id): void {
        if (is_null($id)) return;
        $this->id = $id;
    }

    public function get_name(): string {
        return $this->name;
    }

    public function set_name(string $name): void {
        if (is_null($name)) return;
        $this->name = $name;
    }

    public function get_users(): int {
        return $this->users;
    }

    public function set_users(int $users): void {
        if (is_null($users)) return;
        $this->users = $users;
    }

    public function get_courses(): int {
        return $this->courses;
    }

    public function set_courses(int $courses): void {
        if (is_null($courses)) return;
        $this->courses = $courses;
    }

    public function get_attention(): string {
        return $this->attention;
    }

    public function set_attention(string $attention): void {
        if (is_null($attention)) return;
        $this->attention = $attention;
    }

    public function get_certificate(): string {
        return $this->certificate;
    }

    public function set_certificate(string $certificate): void {
        if (is_null($certificate)) return;
        $this->certificate = $certificate;
    }

    public function get_price(): int {
        return $this->price;
    }

    public function set_price(int $price): void {
        if (is_null($price)) return;
        $this->price = $price;
    }

}