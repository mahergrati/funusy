<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfitController extends AbstractController
{
    #[Route('/profit', name: 'app_profit')]
public function index(Request $request): Response
    {
        $investmentAmount = $request->request->get('investmentAmount');
        $investmentPeriod = $request->request->get('investmentPeriod');
        $projectType = $request->request->get('projectType');
        $profit = null;

        if ($request->isMethod('POST') && $investmentAmount !== null && $investmentPeriod !== null && $projectType !== null) {
            // Calculate profit
            $profit = $this->calculateProfit((float)$investmentAmount, (int)$investmentPeriod, $projectType);
        }

        return $this->render('profit/index.html.twig', [
            'investmentAmount' => $investmentAmount,
            'investmentPeriod' => $investmentPeriod,
            'projectType' => $projectType,
            'profit' => $profit,
        ]);
    }

    private function calculateProfit(float $investmentAmount, int $investmentPeriod, string $projectType): float
    {
        $profitPercentage = match ($projectType) {
            'AGRICULTURE' => $this->calculateProfitPercentageForAgriculture($investmentPeriod),
            'TECHNOLOGIQUE' => $this->calculateProfitPercentageForTechnologique($investmentPeriod),
            'BOURSE' => $this->calculateProfitPercentageForBourse($investmentPeriod),
            'IMMOBILIER' => $this->calculateProfitPercentageForImmobilier($investmentPeriod),
            default => 0.01
        };

        $profitPerMonth = $investmentAmount * $profitPercentage / 12;
        return $profitPerMonth * $investmentPeriod;
    }

    private function calculateProfitPercentageForAgriculture(int $investmentPeriod): float
    {
        return $investmentPeriod <= 6 ? 0.1 : 0.15;
    }

    private function calculateProfitPercentageForTechnologique(int $investmentPeriod): float
    {
        return $investmentPeriod <= 6 ? 0.15 : 0.2;
    }

    private function calculateProfitPercentageForBourse(int $investmentPeriod): float
    {
        return $investmentPeriod <= 12 ? 0.2 : 0.3;
    }

    private function calculateProfitPercentageForImmobilier(int $investmentPeriod): float
    {
        return $investmentPeriod <= 24 ? 0.3 : 0.35;
    }
}
