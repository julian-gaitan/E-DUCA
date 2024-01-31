<?php

include_once 'orm.php';

class InscriptionPay extends ORM {

    protected int $fk_idStudent;
    protected int $fk_idSchedule;
    public const TABLE_NAME = 'tbl_inscripciones_pago';
    public const FIELDS_MAP = [
        'fk_idStudent' => 'idEstudiante',
        'fk_idSchedule' => 'idCronograma',
    ];
    public const INPUTS_MAP = [
        'fk_idStudent' => 'idEstudiante',
        'fk_idSchedule' => 'idCronograma',
    ];

    function __construct() {
        $this->table_name = self::TABLE_NAME;
        $this->fields_map = self::FIELDS_MAP;
        $this->fk_idStudent = 0;
        $this->fk_idSchedule = 0;
    }

    protected function newObj() {
        return new InscriptionPay();
    }

    public function get_fk_idStudent(): int {
        return $this->fk_idStudent;
    }

    public function set_fk_idStudent(int $fk_idStudent): void {
        if (is_null($fk_idStudent)) return;
        $this->fk_idStudent = $fk_idStudent;
    }

    public function get_fk_idSchedule(): int {
        return $this->fk_idSchedule;
    }

    public function set_fk_idSchedule(int $fk_idSchedule): void {
        if (is_null($fk_idSchedule)) return;
        $this->fk_idSchedule = $fk_idSchedule;
    }

}