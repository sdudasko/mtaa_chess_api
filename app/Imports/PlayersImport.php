<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PlayersImport implements ToModel, WithStartRow
{
    protected $tournament = null;

    public function __construct($tournament)
    {
        $this->tournament = $tournament;
    }
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'name'     => $row[1],
            'email'    => $row[2],
            'title'    => $row[3] == '-' ? null : $row[3],
            'elo'    => $row[4],
            'category'    => $row[5],
            'tournament_id' => $this->tournament->id,
            'registration_id' => Str::random(8),
        ]);
    }
}