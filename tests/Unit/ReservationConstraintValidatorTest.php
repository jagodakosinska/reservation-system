<?php

namespace App\Tests\Unit;

use App\DTO\ReservationDTO;
use App\Entity\Schedule;
use App\Entity\Screen;
use App\Repository\ReservationItemRepository;
use App\Repository\ScheduleRepository;
use App\Repository\SeatRepository;
use App\Validator\ReservationConstraint;
use App\Validator\ReservationConstraintValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use function PHPUnit\Framework\once;

class ReservationConstraintValidatorTest extends TestCase
{
    public ReservationConstraintValidator $validator;
    public ReservationConstraint $constraintMock;
    public ReservationItemRepository $reservationItemRepositoryMock;
    public SeatRepository $seatRepositoryMock;
    public $contextMock;
    public $scheduleMock;


    public function setUp(): void
    {
        $this->reservationItemRepositoryMock = $this->createMock(ReservationItemRepository::class);
        $this->seatRepositoryMock = $this->createMock(SeatRepository::class);
        $scheduleRepositoryMock = $this->createMock(ScheduleRepository::class);
        $this->constraintMock = $this->createMock(ReservationConstraint::class);
        $this->scheduleMock = $this->createMock(Schedule::class);
        $screenMock = $this->createMock(Screen::class);
        $screenMock->method('getId')->willReturn(1);
        $this->scheduleMock->method('getScreen')->willReturn($screenMock);
        $this->scheduleMock->method('getId')->willReturn(1);
        $scheduleRepositoryMock->method('find')->willReturn($this->scheduleMock);
        $this->validator = new ReservationConstraintValidator($this->reservationItemRepositoryMock,
            $this->seatRepositoryMock,
            $scheduleRepositoryMock);

        $this->contextMock = $this->createMock(ExecutionContextInterface::class);
        $this->validator->initialize($this->contextMock);

    }

    public function testIncorrectInstanceOfArgumentType()
    {
        // Given
        $value = [];
        // When
        try {
            $this->validator->validate($value, $this->constraintMock);
            $this->fail();
        } catch (UnexpectedTypeException $exception) {
            // Then
            $this->assertStringContainsString('Expected argument of type', $exception->getMessage());
        };
    }

    public function testIfCanMakeReservation()
    {
        // Given
        $request = ReservationDTOTest::createFromJson();
        $value = ReservationDTO::fromRequest($request);
        $this->scheduleMock->method('getStartTime')->willReturn(new \DateTime());
        $this->seatRepositoryMock
            ->expects(self::once())
            ->method('hasSeats')
            ->willReturn(true);
        $this->reservationItemRepositoryMock
            ->expects(self::once())
            ->method('checkIsReserved')
            ->willReturn(false);
        $this->contextMock->expects(once())->method('buildViolation')->with("Could not reserved film 30' before is started!");

        // When

        $this->validator->validate($value, $this->constraintMock);

        // Then


    }

    public function testAttemptReservationOnFakeSeat()
    {
        // Given
        $request = ReservationDTOTest::createFromJson();
        $value = ReservationDTO::fromRequest($request);
        $this->scheduleMock->method('getStartTime')->willReturn(new \DateTime('+ 1 day'));
        $this->seatRepositoryMock
            ->expects(self::once())
            ->method('hasSeats')
            ->willReturn(false);
        $this->reservationItemRepositoryMock
            ->expects(self::once())
            ->method('checkIsReserved')
            ->willReturn(false);
        $this->contextMock->expects(once())->method('buildViolation')->with("Seat doesn't exist!");

        // When

        $this->validator->validate($value, $this->constraintMock);

        // Then
    }

    public function testAttemptReservationOnTakenSeat()
    {
        // Given
        $request = ReservationDTOTest::createFromJson();
        $value = ReservationDTO::fromRequest($request);
        $this->scheduleMock->method('getStartTime')->willReturn(new \DateTime('+ 1 day'));
        $this->seatRepositoryMock
            ->expects(self::once())
            ->method('hasSeats')
            ->willReturn(true);
        $this->reservationItemRepositoryMock
            ->expects(self::once())
            ->method('checkIsReserved')
            ->willReturn(true);
        $this->contextMock->expects(once())->method('buildViolation')->with("Seat is reserved!");

        // When

        $this->validator->validate($value, $this->constraintMock);

        // Then
    }
}