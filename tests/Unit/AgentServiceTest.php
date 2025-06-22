<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\AgentService;
use App\Repositories\AgentRepository;
use Mockery;
use App\Models\Agent;

class AgentServiceTest extends TestCase
{
    public function test_create_agent_encodes_unicode_correctly()
    {
        $repo = Mockery::mock(AgentRepository::class);
        $service = new AgentService($repo);
        $data = [
            'name' => 'Тест',
            'purpose' => 'Проверка',
            'style' => 'Стиль',
            'tools' => ['Ключ', 'Значение'],
            'interaction' => ['chat'],
            'description' => 'Описание',
        ];
        $expected = $data;
        $expected['tools'] = json_encode($data['tools'], JSON_UNESCAPED_UNICODE);
        $expected['interaction'] = json_encode($data['interaction'], JSON_UNESCAPED_UNICODE);
        $agent = new Agent($expected);
        $agent->id = 1;
        $repo->shouldReceive('create')->once()->with($expected)->andReturn($agent);
        $result = $service->createAgent($data);
        $this->assertEquals(1, $result->id);
        $this->assertEquals($expected['tools'], $result->tools);
        $this->assertEquals($expected['interaction'], $result->interaction);
    }
} 