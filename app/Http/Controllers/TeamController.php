<?php

namespace App\Http\Controllers;

class TeamController extends Controller
{
    public function index()
    {
        $teams = [
            [
                'name' => "Dahlia Indah Amareta, S.KM, M.Gizi",
                'image' => "https://kesehatan.polije.ac.id/img/foto/2%20Dahlia%20Indah%20Amareta.jpg",
            ],
            [
                'name' => "Galih Purnamasari, S.Gz, M.Si",
                'image' => "https://kesehatan.polije.ac.id/img/foto/44%20Galih.JPG",
            ],
            [
                'name' => "Efri Tri Ardianto, S.KM, M.Kes",
                'image' => "https://kesehatan.polije.ac.id/img/foto/19%20Efri%20Tri.jpg",
            ],
            [
                'name' => "Alinea Dwi Elisanti, S.KM, M.Kes",
                'image' => "https://kesehatan.polije.ac.id/img/foto/38%20Alinea.JPG",
            ]
        ];

        return [
            'success' => true,
            'message' => "Data tim berhasil diambil",
            'data' => [
                'teams' => $teams,
            ]
        ];
    }
}
