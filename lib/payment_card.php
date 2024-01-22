<?php

include_once 'orm.php';

class PaymentCard extends ORM {
    
    protected int $id;
    protected int $number;
    protected string $name;
    protected string $expiration_date;
    protected int $cvv;
    protected int $fk_student;
    public const TABLE_NAME = 'tbl_tarjetas_debito_credito';
    public const FIELDS_MAP = [
        'id' => 'id',
        'number' => 'numero',
        'name' => 'nombre',
        'expiration_date' => 'fecha_vencimiento',
        'cvv' => 'cvv',
        'fk_student' => 'fk_estudiante',
    ];
    public const INPUTS_MAP = [
        'id' => 'id',
    ];

    function __construct() {
        $this->table_name = self::TABLE_NAME;
        $this->fields_map = self::FIELDS_MAP;
        $this->id = 0;
        $this->number = 0;
        $this->name = "";
        $this->expiration_date = "";
        $this->cvv = 0;
        $this->fk_student = 0;
    }

    protected function newObj() {
        return new PaymentCard();
    }

    public function get_id(): int {
        return $this->id;
    }

    public function set_id(int $id): void {
        if (is_null($id)) return;
        $this->id = $id;
    }

    public function get_number(): int {
        return $this->number;
    }

    public function set_number(int $number): void {
        if (is_null($number)) return;
        $this->number = $number;
    }

    public function get_name(): string {
        return $this->name;
    }

    public function set_name(string $name): void {
        if (is_null($name)) return;
        $this->name = $name;
    }

    public function get_expiration_date(): string {
        return $this->expiration_date;
    }

    public function set_expiration_date(string $expiration_date): void {
        if (is_null($expiration_date)) return;
        $this->expiration_date = $expiration_date;
    }

    public function get_cvv(): int {
        return $this->cvv;
    }

    public function set_cvv(int $cvv): void {
        if (is_null($cvv)) return;
        $this->cvv = $cvv;
    }

    public function get_fk_student(): int {
        return $this->fk_student;
    }

    public function set_fk_student(int $fk_student): void {
        if (is_null($fk_student)) return;
        $this->fk_student = $fk_student;
    }
}