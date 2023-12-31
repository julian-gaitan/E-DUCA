<?php

include_once 'orm.php';

class User extends ORM {

    protected int $id;
    protected string $first_name;
    protected string $last_name;
    protected string $user;
    protected string $email;
    protected string $password;
    protected string $birthdate;
    protected int $role;
    public const TABLE_NAME = 'tbl_usuarios';
    public const FIELDS_MAP = [
        'id' => 'id',
        'first_name' => 'nombres',
        'last_name' => 'apellidos',
        'user' => 'usuario',
        'email' => 'correo',
        'password' => 'contrasena',
        'birthdate' => 'cumpleanos',
        'role' => 'rol',
    ];
    public const INPUTS_MAP = [
        'id' => 'id',
        'first-name' => 'nombres',
        'last-name' => 'apellidos',
        'user' => 'usuario',
        'email' => 'correo',
        'password' => 'contrasena',
        'birthdate' => 'cumpleanos',
        'role' => 'rol',
    ];

    function __construct() {
        $this->table_name = self::TABLE_NAME;
        $this->fields_map = self::FIELDS_MAP;
        $this->id = 0;
        $this->first_name = "";
        $this->last_name = "";
        $this->user = "";
        $this->email = "";
        $this->password = "";
        $this->birthdate = "";
        $this->role = 1;
    }

    protected function newObj() {
        return new User();
    }

    public function get_id(): int {
        return $this->id;
    }

    public function set_id(int $id): void {
        if (is_null($id)) return;
        $this->id = $id;
    }

    public function get_first_name(): string {
        return $this->first_name;
    }

    public function set_first_name(string $first_name): void {
        if (is_null($first_name)) return;
        $this->first_name = $first_name;
    }

    public function get_last_name(): string {
        return $this->last_name;
    }

    public function set_last_name(string $last_name): void {
        if (is_null($last_name)) return;
        $this->last_name = $last_name;
    }

    public function get_full_name(): string {
        return $this->get_first_name() . " " . $this->get_last_name();
    }

    public function get_user(): string {
        return $this->user;
    }

    public function set_user(string $user): void {
        if (is_null($user)) return;
        $this->user = $user;
    }

    public function get_email(): string {
        return $this->email;
    }

    public function set_email(string $email): void {
        if (is_null($email)) return;
        $this->email = $email;
    }

    public function get_password(): string {
        return $this->password;
    }

    public function set_password(string $password): void {
        if (is_null($password)) return;
        $this->password = $password;
    }

    public function get_birthdate(): string {
        return $this->birthdate;
    }

    public function set_birthdate(string|null $birthdate): void {
        if (is_null($birthdate)) return;
        $this->birthdate = $birthdate;
    }

    public function get_role(): int {
        return $this->role;
    }

    public function set_role(int|null $role): void {
        if (is_null($role)) return;
        $this->role = $role;
    }
}
