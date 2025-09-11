<?php

namespace App\Http\Controllers;

class TeamController extends Controller
{
    public function index()
    {
        $leader = [
            'name' => "Galih Purnamasari, S.Gz, M.Si.",
            'image' => "https://kesehatan.polije.ac.id/img/foto/44%20Galih.JPG",
        ];

        $teams = [
            [
                'name' => "Dahlia Indah Amareta, S.KM., M.Kes./Gizi Masyarakat",
                'image' => "https://kesehatan.polije.ac.id/img/foto/2%20Dahlia%20Indah%20Amareta.jpg",
            ],
            [
                'name' => "Alinea Dwi Elisanti, S.KM., M.Kes./Kesehatan Masyarakat",
                'image' => "https://kesehatan.polije.ac.id/img/foto/38%20Alinea.JPG",
            ],
            [
                'name' => "Efri Tri Ardianto, S.KM., M.Kes./Statistik Kesehatan",
                'image' => "https://kesehatan.polije.ac.id/img/foto/19%20Efri%20Tri.jpg",
            ],
            [
                'name' => "Agustina Endah Werdiharini, S.Sos., M.Kes./Kesehatan Masyarakat",
                'image' => "https://kesehatan.polije.ac.id/img/foto/12%20Endah.jpg",
            ]
        ];

        return [
            'success' => true,
            'message' => "Data tim berhasil diambil",
            'data' => [
                'leader' => $leader,
                'teams' => $teams,
            ]
        ];
    }
}
