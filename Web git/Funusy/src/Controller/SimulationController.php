<?php

namespace App\Controller;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class SimulationController extends AbstractController
{
    #[Route('/simulation/f', name: 'app_simulation_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        // Récupérer les paramètres de la simulation depuis la requête (montant, durée, taux)
        $montant = floatval($request->query->get('montant'));
        $duree = intval($request->query->get('duree'));
        $taux = floatval($request->query->get('taux'));

        // Calculer les échéances
        $echeances = $this->calculerEcheances($montant, $duree, $taux);

        return $this->render('simulation/index.html.twig', [
            'echeances' => $echeances,
            'montant' => $montant,
            'duree' => $duree,
            'taux' => $taux
        ]);
    }

    private function calculerEcheances($montant, $duree, $taux): array
    {
        $echeances = [];

        // Vérifier si le taux est différent de zéro pour éviter la division par zéro
        if ($taux != 0 && $duree != 0) {
            // Calcul des échéances
            $tauxMensuel = $taux / 100 / 12;
            $mensualite = $montant * ($tauxMensuel) / (1 - pow(1 + $tauxMensuel, -$duree));
            $valeurResiduelle = $montant;

            for ($i = 1; $i <= $duree; $i++) {
                $interets = $valeurResiduelle * $tauxMensuel;
                $principal = $mensualite - $interets;
                $valeurResiduelle -= $principal;

                if ($i == $duree) {
                    $valeurResiduelle = 0.00;
                }

                $echeance = [
                    'numero' => $i,
                    'echeance' => (new \DateTime('now'))->modify("+{$i} months"),
                    'principal' => $principal,
                    'valeurResiduelle' => $valeurResiduelle,
                    'interets' => $interets,
                    'mensualite' => $mensualite,
                ];

                $echeances[] = $echeance;
            }
        }

        // Ajouter une ligne pour le total
        $totalPrincipal = $montant;
        $totalInterets = array_sum(array_column($echeances, 'interets'));
        $totalMensualites = array_sum(array_column($echeances, 'mensualite'));

        $totalEcheance = [
            'numero' => $duree + 1,
            'echeance' => null,
            'principal' => $totalPrincipal,
            'valeurResiduelle' => 0,
            'interets' => $totalInterets,
            'mensualite' => $totalMensualites,
        ];

        $echeances[] = $totalEcheance;

        return $echeances;
    }

    #[Route('/simulation/export', name: 'app_simulation_export', methods: ['GET', 'POST'])]
    public function exportToExcel(Request $request): Response
    {
        // Récupérer les échéances depuis la requête (ou depuis la base de données)
        $montant = floatval($request->request->get('montant'));
        $duree = intval($request->request->get('duree'));
        $taux = floatval($request->request->get('taux'));
        $echeances = $this->calculerEcheances($montant, $duree, $taux);

        // Créer un nouveau objet Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // En-têtes de colonne
        $sheet->setCellValue('A1', 'Numéro');
        $sheet->setCellValue('B1', 'Échéance');
        $sheet->setCellValue('C1', 'Principal');
        $sheet->setCellValue('D1', 'Valeur Résiduelle');
        $sheet->setCellValue('E1', 'Intérêts');
        $sheet->setCellValue('F1', 'Mensualité');

        // Remplir les données des échéances
        $row = 2;
        foreach ($echeances as $echeance) {
            $sheet->setCellValue('A' . $row, $echeance['numero']);
            // Vérifier si la date d'échéance est définie avant d'appeler la méthode format
            $echeanceDate = $echeance['echeance'] ? $echeance['echeance']->format('Y-m-d') : '';
            $sheet->setCellValue('B' . $row, $echeanceDate);
            $sheet->setCellValue('C' . $row, $echeance['principal']);
            $sheet->setCellValue('D' . $row, $echeance['valeurResiduelle']);
            $sheet->setCellValue('E' . $row, $echeance['interets']);
            $sheet->setCellValue('F' . $row, $echeance['mensualite']);
            $row++;
        }

        // Générer le fichier Excel
        $writer = new Xlsx($spreadsheet);
        $fileName = 'echeances.xlsx';
        $writer->save($fileName);

        // Envoyer le fichier Excel en réponse
        return $this->file($fileName, 'echeances.xlsx', ResponseHeaderBag::DISPOSITION_INLINE);
    }
}
