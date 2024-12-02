<?php

namespace App\Repositories;

class BaseRepository {

  protected bool $status = false;

  protected int $status_code = 0;

  protected string $error_message = "";

  protected string $success_message = "";

  protected $data;

  protected function setStatus(bool $status): void 
  {
    $this->status = $status;
  }

  public function getStatus(): bool 
  {
    return $this->status;
  }

  protected function setStatusCode(int $status_code): void 
  {
    $this->status_code = $status_code;
  }

  public function getStatusCode(): int 
  {
    return $this->status_code;
  }

  protected function setErrorMessage(string $error_message): void 
  {
    $this->error_message = $error_message;
  }

  public function getErrorMessage(): string 
  {
    return $this->error_message;
  }

  protected function setSuccessMessage(string $success_message): void 
  {
    $this->success_message = $success_message;
  }

  public function getSuccessMessage(): string 
  {
    return $this->success_message;
  }

  protected function setData($data): void
  {
    $this->data = $data;
  }

  public function getData(): array|object|null
  {
    return $this->data;
  }

}