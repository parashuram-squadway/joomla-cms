<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  System.Debug
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

use Joomla\Profiler\ProfilerRendererInterface;

/**
 * Joomla! Debug plugin.
 *
 * @since  __DEPLOY_VERSION__
 */
class PlgSystemDebugRenderer implements ProfilerRendererInterface
{
	/**
	 * Render the profiler.
	 *
	 * @param   \Joomla\Profiler\ProfilerInterface  $profiler  The profiler to render.
	 *
	 * @return  string  The rendered profiler.
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function render(\Joomla\Profiler\ProfilerInterface $profiler)
	{
		$html      = array();
		$marks     = array();
		$totalMem  = 0;
		$totalTime = 0;

		/** @var \Joomla\Profiler\ProfilePointInterface $lastPoint **/
		$lastPoint = null;

		foreach ($profiler->getPoints() as $point)
		{
			$previousTime = $lastPoint ? $lastPoint->getTime() : 0.0;
			$previousMem  = $lastPoint ? $lastPoint->getMemoryMegaBytes() : 0;
			$totalTime   += $point->getTime();
			$totalMem    += $point->getMemoryBytes();

			$htmlMark = sprintf(
				JText::_('PLG_DEBUG_TIME') . ': <span class="label label-time">%.1f&nbsp;ms</span> / <span class="label">%.1f&nbsp;ms</span>'
				. ' ' . JText::_('PLG_DEBUG_MEMORY') . ': <span class="label label-memory">%0.3f MB</span> / <span class="label">%0.2f MB</span>'
				. ' %s: %s',
				($point->getTime() - $previousTime) * 1000,
				$point->getTime() * 1000,
				$point->getMemoryMegaBytes() - $previousMem,
				$point->getMemoryMegaBytes(),
				$profiler->getName(),
				$point->getName()
			);

			$marks[] = (object) array(
				'time' => $point->getTime(),
				'memory' => $point->getMemoryMegaBytes(),
				'html' => $htmlMark,
				'tip' => $point->getName()
			);

			$lastPoint = $point;
		}

		$avgTime = $totalTime / count($marks);
		$avgMem  = $totalMem / count($marks);

		foreach ($marks as $mark)
		{
			if ($mark->time > $avgTime * 1.5)
			{
				$barClass = 'bar-danger';
				$labelClass = 'label-important';
			}
			elseif ($mark->time < $avgTime / 1.5)
			{
				$barClass = 'bar-success';
				$labelClass = 'label-success';
			}
			else
			{
				$barClass = 'bar-warning';
				$labelClass = 'label-warning';
			}

			if ($mark->memory > $avgMem * 1.5)
			{
				$barClassMem = 'bar-danger';
				$labelClassMem = 'label-important';
			}
			elseif ($mark->memory < $avgMem / 1.5)
			{
				$barClassMem = 'bar-success';
				$labelClassMem = 'label-success';
			}
			else
			{
				$barClassMem = 'bar-warning';
				$labelClassMem = 'label-warning';
			}

			$bars[] = (object) array(
				'width' => round($mark->time / ($totalTime / 100), 4),
				'class' => $barClass,
				'tip' => $mark->tip
			);

			$barsMem[] = (object) array(
				'width' => round($mark->memory / ($totalMem / 100), 4),
				'class' => $barClassMem,
				'tip' => $mark->tip
			);

			$htmlMarks[] = '<div>' . str_replace('label-time', $labelClass, str_replace('label-memory', $labelClassMem, $mark->html)) . '</div>';
		}

		$html[] = '<h4>' . JText::_('PLG_DEBUG_TIME') . '</h4>';
		$html[] = $this->renderBars($bars, 'profile');
		$html[] = '<h4>' . JText::_('PLG_DEBUG_MEMORY') . '</h4>';
		$html[] = $this->renderBars($barsMem, 'profile');

		$html[] = '<div class="dbg-profile-list">' . implode('', $htmlMarks) . '</div>';

		return implode('', $html);
	}


	/**
	 * Render the bars.
	 *
	 * @param   array    &$bars  Array of bar data
	 * @param   string   $class  Optional class for items
	 * @param   integer  $id     Id if the bar to highlight
	 *
	 * @return  string
	 *
	 * @since   3.1.2
	 */
	protected function renderBars(&$bars, $class = '', $id = null)
	{
		$html = array();

		foreach ($bars as $i => $bar)
		{
			if (isset($bar->pre) && $bar->pre)
			{
				$html[] = '<div class="dbg-bar-spacer" style="width:' . $bar->pre . '%;"></div>';
			}

			$barClass = trim('bar dbg-bar ' . (isset($bar->class) ? $bar->class : ''));

			if ($id !== null && $i == $id)
			{
				$barClass .= ' dbg-bar-active';
			}

			$tip = '';

			if (isset($bar->tip) && $bar->tip)
			{
				$barClass .= ' hasTooltip';
				$tip = JHtml::tooltipText($bar->tip, '', 0);
			}

			$html[] = '<a class="bar dbg-bar ' . $barClass . '" title="' . $tip . '" style="width: ' .
						$bar->width . '%;" href="#dbg-' . $class . '-' . ($i + 1) . '"></a>';
		}

		return '<div class="progress dbg-bars dbg-bars-' . $class . '">' . implode('', $html) . '</div>';
	}
}
