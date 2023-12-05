<?php

include_once 'orm.php';

class Schedule extends ORM {

    protected int $id;
    protected int $fk_course;
    protected string $start_date;
    protected string $end_date;
    protected int $duration;
    public const TABLE_NAME = 'tbl_cronogramas';
    public const FIELDS_MAP = [
        'id' => 'id',
        'fk_course' => 'fk_curso',
        'start_date' => 'fecha_inicio',
        'end_date' => 'fecha_fin',
        'duration' => 'duracion',
    ];
    public const INPUTS_MAP = [
        'id' => 'id',
        'course' => 'fk_curso',
        'start-date' => 'fecha_inicio',
        'end-date' => 'fecha_fin',
        'duration' => 'duracion',
    ];

    function __construct() {
        $this->table_name = self::TABLE_NAME;
        $this->fields_map = self::FIELDS_MAP;
        $this->id = 0;
        $this->fk_course = 0;
        $this->start_date = "";
        $this->end_date = "";
        $this->duration = 0;
    }

    protected function newObj() {
        return new Schedule();
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

    public function get_start_date(): string {
        return $this->start_date;
    }

    public function set_start_date(string $start_date): void {
        if (is_null($start_date)) return;
        $this->start_date = $start_date;
    }

    public function get_end_date(): string {
        return $this->end_date;
    }

    public function set_end_date(string $end_date): void {
        if (is_null($end_date)) return;
        $this->end_date = $end_date;
    }

    public function get_duration(): int {
        return $this->duration;
    }

    public function set_duration(int $duration): void {
        if (is_null($duration)) return;
        $this->duration = $duration;
    }

}