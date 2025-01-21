<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MessengerRepository;


#[ORM\Entity(repositoryClass: MessengerRepository::class)]

class MessengerMessages
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id", type: "bigint", nullable: false)]
    private ?int $id;

    #[ORM\Column(name: "body", type: "text", length: 0, nullable: false)]
    private string $body;

    #[ORM\Column(name: "headers", type: "text", length: 0, nullable: false)]
    private string $headers;

    #[ORM\Column(name: "queue_name", type: "string", length: 190, nullable: false)]
    private string $queueName;

    #[ORM\Column(name: "created_at", type: "datetime", nullable: false)]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(name: "available_at", type: "datetime", nullable: false)]
    private \DateTimeInterface $availableAt;

    #[ORM\Column(name: "delivered_at", type: "datetime", nullable: true)]
    private ?\DateTimeInterface $deliveredAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): static
    {
        $this->body = $body;

        return $this;
    }

    public function getHeaders(): ?string
    {
        return $this->headers;
    }

    public function setHeaders(string $headers): static
    {
        $this->headers = $headers;

        return $this;
    }

    public function getQueueName(): ?string
    {
        return $this->queueName;
    }

    public function setQueueName(string $queueName): static
    {
        $this->queueName = $queueName;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getAvailableAt(): ?\DateTimeInterface
    {
        return $this->availableAt;
    }

    public function setAvailableAt(\DateTimeInterface $availableAt): static
    {
        $this->availableAt = $availableAt;

        return $this;
    }

    public function getDeliveredAt(): ?\DateTimeInterface
    {
        return $this->deliveredAt;
    }

    public function setDeliveredAt(?\DateTimeInterface $deliveredAt): static
    {
        $this->deliveredAt = $deliveredAt;

        return $this;
    }
}
