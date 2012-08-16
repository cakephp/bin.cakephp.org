<div class="paste paste-view">

<div class="row">
	<div class="columns nine">
		<div class="code body" lang="<?php echo h($paste['Paste']['lang']); ?>">
			<?php echo $this->Geshi->highlightText($paste['Paste']['body'], $paste['Paste']['lang']);?>
		</div>
	</div>
	<div class="columns three">
		<?php if (!empty($original) || !empty($versions)):
			echo $this->element('versions');
		endif;
		?>
		<dl class="paste-metadata">
			<?php if ($paste['Paste']['save']): ?>
			<dd>
				<span class="saved round label green">saved</span>
			</dd>
			<?php endif;?>
			
			<dt>Language</dt>
			<dd class="lang">
				<?php echo h($paste['Paste']['lang']); ?>
			</dd>

			<dt>Pasted on</dt>
			<dd>
				<?php echo $this->Time->timeAgoInWords($paste['Paste']['created']); ?>
			</dd>

			<dt>By</dt>
			<dd>
			<?php echo $this->Html->link($paste['Paste']['nick'], array('action' => 'nick', $paste['Paste']['nick'])); ?>
			</dd>

			<dt>Note</dt>
			<dd>
			<?php
				if (empty($paste['Paste']['note'])):
					echo h($paste['Paste']['nick']) . ' did not leave a note';
				else:
					echo nl2br(h($paste['Paste']['note']));
				endif;
			?>
			</dd>

			<?php if($paste['Paste']['save']): ?>
			<dt>Tags</dt>
			<dd>
				<?php echo $this->Cakebin->aList($paste['Tag']); ?>
				<div class="tags">
					<?php echo $this->Html->link(
						'add more',
						array('controller' => 'pastes', 'action' => 'tag', $paste['Paste']['id']),
						array('update'=>'tags')
					);
					?>
				</div>
			</dd>
			<?php endif; ?>
		</dl>

		<a href="#modify" class="tiny pale button modify-paste">
			Modify this Paste
		</a>
	</div>
</div>
</div>

<?php echo $this->element('modify'); ?>
