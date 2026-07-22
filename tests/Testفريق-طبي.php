<?php

namespace App\Tests\Controller;

use PHPUnit\Framework\TestCase;
use App\Controller\TeamController;
use App\Repository\TeamRepository;
use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class Testفريق-طبي extends TestCase
{
    private $teamController;
    private $teamRepository;
    private $entityManager;
    private $router;

    protected function setUp(): void
    {
        $this->teamRepository = $this->createMock(TeamRepository::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->router = $this->createMock(RouterInterface::class);

        $this->teamController = new TeamController($this->teamRepository, $this->entityManager, $this->router);
    }

    public function testGetAllTeams()
    {
        $teams = [new Team(), new Team()];
        $this->teamRepository->expects($this->once())
            ->method('findAll')
            ->willReturn($teams);

        $response = $this->teamController->getAllTeams();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(json_encode($teams), $response->getContent());
    }

    public function testGetTeamById()
    {
        $team = new Team();
        $team->setId(1);
        $this->teamRepository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($team);

        $response = $this->teamController->getTeamById(1);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(json_encode($team), $response->getContent());
    }

    public function testCreateTeam()
    {
        $team = new Team();
        $team->setName('Team Name');
        $this->teamRepository->expects($this->once())
            ->method('save')
            ->with($team)
            ->willReturn($team);

        $request = new Request();
        $request->request->set('name', 'Team Name');
        $response = $this->teamController->createTeam($request);
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals(json_encode($team), $response->getContent());
    }

    public function testUpdateTeam()
    {
        $team = new Team();
        $team->setId(1);
        $team->setName('Team Name');
        $this->teamRepository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($team);
        $this->teamRepository->expects($this->once())
            ->method('save')
            ->with($team)
            ->willReturn($team);

        $request = new Request();
        $request->request->set('name', 'Team Name');
        $response = $this->teamController->updateTeam(1, $request);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(json_encode($team), $response->getContent());
    }

    public function testDeleteTeam()
    {
        $team = new Team();
        $team->setId(1);
        $this->teamRepository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($team);
        $this->teamRepository->expects($this->once())
            ->method('remove')
            ->with($team);

        $response = $this->teamController->deleteTeam(1);
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }
}


Note: This test file assumes that the `TeamController` class has the following methods:

- `getAllTeams()`: Returns a response with a list of teams.
- `getTeamById($id)`: Returns a response with a team by its ID.
- `createTeam(Request $request)`: Creates a new team and returns a response with the created team.
- `updateTeam($id, Request $request)`: Updates a team by its ID and returns a response with the updated team.
- `deleteTeam($id)`: Deletes a team by its ID and returns a response with a status code of 204 (No Content).

Also, this test file assumes that the `TeamRepository` class has the following methods:

- `findAll()`: Returns a list of all teams.
- `find($id)`: Returns a team by its ID.
- `save($team)`: Saves a team.
- `remove($team)`: Removes a team.