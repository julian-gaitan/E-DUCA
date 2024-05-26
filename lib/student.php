<?php

include_once 'orm.php';

class Student extends ORM {

    protected int $id;
    protected int $subscription;
    public const TABLE_NAME = 'tbl_estudiantes';
    public const FIELDS_MAP = [
        'id' => 'id',
        'subscription' => 'suscripcion',
    ];
    public const INPUTS_MAP = [
        'id' => 'id',
        'subscription' => 'suscripcion',
    ];

    function __construct() {
        $this->table_name = self::TABLE_NAME;
        $this->fields_map = self::FIELDS_MAP;
        $this->id = 0;
        $this->subscription = 0;
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

    public function get_subscription(): int {
        return $this->subscription;
    }

    public function set_subscription(int $subscription): void {
        if (is_null($subscription)) return;
        $this->subscription = $subscription;
    }
}
