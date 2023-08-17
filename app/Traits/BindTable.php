<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait BindTable
{
    protected $connection = null;

    protected $table = null;

    protected $model = null;

    protected $schema = null;

    public function bind(string $connection, string $table)
    {
        $this->setConnection($connection);
        $this->setTable($table);
    }

    public function newInstance($attributes = [], $exists = false)
    {
        // Overridden in order to allow for late table binding.

        $this->model = parent::newInstance($attributes, $exists);
        $this->model->setTable($this->table);

        return $this->model;
    }

    public function getSchemaName(string $id)
    {
        return DB::table('master')
            ->where('id', $id)
            ->first()->prefix;
    }

    public function formUpdateData(array $data)
    {
        return array_merge($data, ['updated_at' => Carbon::now()->format('Y-m-d H:i:s.v')]);
    }

    public function validateUuid(string $uuid)
    {
        if (! is_valid_uuid($uuid)) {
            return 'Invalid format id';
        }
    }
}
