<?php
/**
 * Copyright © 2026 Roman Pasichnyk
 * SPDX-License-Identifier: OSL-3.0 OR AFL-3.0
 *
 * Zero_ReviewsAiAssistant: the AI Assistant's and the Claude connector's tools for Zero Reviews
 * (list_reviews, moderate_reviews, and the /reviews command).
 */
use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(ComponentRegistrar::MODULE, 'Zero_ReviewsAiAssistant', __DIR__);
