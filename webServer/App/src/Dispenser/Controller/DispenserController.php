<?php

namespace App\Dispenser\Controller;

use App\Dispenser\Application\CreateDispenser;
use App\Dispenser\Application\Finder\FindDispenserById;
use App\Dispenser\Application\AmountSpent;
use App\Dispenser\Application\UpdateDispenserStatus;
use App\Dispenser\Domain\Contracts\IFormatDispenserResponse;
use App\Dispenser\Domain\Dispenser;
use App\Dispenser\Domain\Status;
use App\Shared\HttpCodes\HttpCodes;
use App\Shared\Uuid\UuidGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

/**
 * @Route("/dispenser")
 */
class DispenserController extends AbstractController
{
    /**
     * @Route("", name="create_dispenser", methods={"POST"})
     * @param Request $request
     * @param CreateDispenser $create
     * @param IFormatDispenserResponse $dispenserWithOutStateResponse
     * @return JsonResponse
     */
    public function createDispenser(Request $request, CreateDispenser $create, IFormatDispenserResponse $dispenserWithOutStateResponse): JsonResponse
    {
        try {
            $content = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

            $dispenser = Dispenser::build(
                UuidGenerator::random(), $content['flow_volume'], [Status::build('close')]
            );
            $create($dispenser);

            return $this->json($dispenserWithOutStateResponse($dispenser));

        } catch (Throwable $e) {
            return $this->json($e->getMessage(), ($e->getCode() >= 200 ? $e->getCode() : 400));
        }
    }

    /**
     * @Route("/{dispenserId}/status", name="update_dispenser_status", methods={"PUT"})
     * @param $dispenserId
     * @param Request $request
     * @param UpdateDispenserStatus $updateDispenserStatus
     * @return JsonResponse
     */
    public function updateDispenserStatus($dispenserId, Request $request, UpdateDispenserStatus $updateDispenserStatus): JsonResponse
    {
        try {
            $content = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
            $status = Status::build($content['status'], $content['updated_at'] ?? null);
            $updateDispenserStatus($dispenserId, $status);

            return $this->json($status->toArray(), HttpCodes::ACCEPTED);

        } catch (Throwable $e) {
            return $this->json($e->getMessage(), ($e->getCode() >= 200 ? $e->getCode() : 400));
        }
    }

    /**
     * @Route("/{dispenserId}/spending", name="get_dispenser_spending", methods={"GET"})
     * @param $dispenserId
     * @param AmountSpent $amountSpent
     * @return JsonResponse
     */
    public function getDispenserSpending($dispenserId, AmountSpent $amountSpent): JsonResponse
    {
        try {
            $spent = $amountSpent($dispenserId);
            return $this->json($spent->toArray(), HttpCodes::SUCCESS);

        } catch (Throwable $e) {
            return $this->json($e->getMessage(), $e->getCode());
        }
    }
}
