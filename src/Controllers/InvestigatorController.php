<?php

namespace App\Controllers;

use App\DTO\SaveInvestigatorDTO;
use App\Services\InvestigatorService;
use App\Validation\InvestigatorValidation;
use Throwable;

class InvestigatorController extends AbstractController
{
  private InvestigatorService $investigatorService;

  public function __construct(InvestigatorService $service)
  {
    $this->investigatorService = $service;
  }

  public function list()
  {
    try {
      $data = $this->investigatorService->getAllInvestigators();
      $this->JSONResponse($data);
    } catch (Throwable $e){
      $this->ErrorResponse($e);
    }
  }

  public function show(string $id)
  {
    try {
      $investigator = $this->investigatorService->getInvestigatorDetails($id);
      $this->JSONResponse($investigator, 200);
    } catch (Throwable $e) {
      $this->ErrorResponse($e);
    }
  }

  public function create()
  {
    try {

      $payload = json_decode(file_get_contents("php://input"), true) ?? [];

      InvestigatorValidation::validateInput($payload);

      $dto = SaveInvestigatorDTO::createFromArray($payload);

      $createdDTO = $this->investigatorService->createInvestigator($dto);
      $this->JSONResponse($createdDTO);
    } catch (Throwable $th) {
      $this->ErrorResponse($th);
    }
  }

  public function delete(string $id)
  {
    try {

      $this->investigatorService->deleteInvestigator($id);

      $this->JSONResponse(null, 204);
    } catch (Throwable $th) {
      $this->ErrorResponse($th);
    }
  }

  public function update(string $id)
  {
    try {
      
      $payload = json_decode(file_get_contents("php://input"), true) ?? [];
  
      InvestigatorValidation::validateInput($payload);

      $dto = SaveInvestigatorDTO::createFromArray($payload);
      $updatedDTO = $this->investigatorService->updateInvestigator($id, $dto);

      $this->JSONResponse($updatedDTO);
    } catch (Throwable $th) {
      $this->ErrorResponse($th);
    }

  }
}