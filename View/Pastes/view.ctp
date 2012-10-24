<div class="paste paste-view">
	<div class="row">
		<div class="columns nine">
			<div class="code-body" lang="<?php echo h($paste['Paste']['lang']); ?>">
				<?php echo $this->Geshi->highlightAsTable($paste['Paste']['body'], $paste['Paste']['lang']);?>
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

				<?php if($paste['Paste']['save'] && count($paste['Tag'])): ?>
				<dt>Tags</dt>
				<dd>
					<?php echo $this->Cakebin->aList($paste['Tag']); ?>
				</dd>
				<?php endif; ?>
			</dl>

			<div class="row form-field">
				<?php echo $this->Html->link(
					'View original',
					array('action' => 'raw', $paste['Paste']['temp']), 
					array('class' => 'button tiny blue')
				); ?>
			</div>

			<div class="row form-field">
				<a href="#modify" class="tiny red button modify-paste">
					Modify this Paste
				</a>
			</div>

		</div>
	</div>
</div>

<?php echo $this->element('modify'); ?>
