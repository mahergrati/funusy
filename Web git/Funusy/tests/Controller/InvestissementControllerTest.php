<?php

namespace App\Test\Controller;

use App\Entity\Investissement;
use App\Repository\InvestissementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InvestissementControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private InvestissementRepository $repository;
    private string $path = '/invest/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Investissement::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Investissement index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'investissement[montant]' => 'Testing',
            'investissement[dateInv]' => 'Testing',
            'investissement[periode]' => 'Testing',
            'investissement[idUser]' => 'Testing',
            'investissement[idProjet]' => 'Testing',
        ]);

        self::assertResponseRedirects('/invest/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Investissement();
        $fixture->setMontant('My Title');
        $fixture->setDateInv('My Title');
        $fixture->setPeriode('My Title');
        $fixture->setIdUser('My Title');
        $fixture->setIdProjet('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Investissement');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Investissement();
        $fixture->setMontant('My Title');
        $fixture->setDateInv('My Title');
        $fixture->setPeriode('My Title');
        $fixture->setIdUser('My Title');
        $fixture->setIdProjet('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'investissement[montant]' => 'Something New',
            'investissement[dateInv]' => 'Something New',
            'investissement[periode]' => 'Something New',
            'investissement[idUser]' => 'Something New',
            'investissement[idProjet]' => 'Something New',
        ]);

        self::assertResponseRedirects('/invest/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getMontant());
        self::assertSame('Something New', $fixture[0]->getDateInv());
        self::assertSame('Something New', $fixture[0]->getPeriode());
        self::assertSame('Something New', $fixture[0]->getIdUser());
        self::assertSame('Something New', $fixture[0]->getIdProjet());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Investissement();
        $fixture->setMontant('My Title');
        $fixture->setDateInv('My Title');
        $fixture->setPeriode('My Title');
        $fixture->setIdUser('My Title');
        $fixture->setIdProjet('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/invest/');
    }
}
