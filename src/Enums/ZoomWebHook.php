<?php

namespace MacsiDigital\Zoom\Enums;

use BenSampo\Enum\Enum;

final class ZoomWebHook extends Enum
{
    const EVENT_MEETING_CREATED = 'meeting.created';
    const EVENT_MEETING_STARTED = 'meeting.started';
    const EVENT_MEETING_ENDED = 'meeting.ended';
    const EVENT_WEBINAR_CREATED = 'webinar.created';
    const EVENT_WEBINAR_STARTED = 'webinar.started';
    const EVENT_WEBINAR_ENDED = 'webinar.ended';
    const EVENT_RECORDING_COMPLETED = 'recording.completed';
}
