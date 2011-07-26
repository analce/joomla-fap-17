<?php
/** $Id: default_form.php 73 2008-09-17 09:52:52Z elpaso $ */
defined( '_JEXEC' ) or die( 'Restricted access' );

// ABP:mods for auto subject

$auto_subject = urldecode(JRequest::getString('contact_subject', ''));

if($auto_subject){
	$auto_text = 'Desidero ricevere una copia della pubblicazione: ' . $auto_subject;
	$auto_text .= "\nIl mio recapito è:\n";
	$auto_text .= "Nome e cognome: \n";
	$auto_text .= "Via e numero civico: \n";
 	$auto_text .= "CAP e Città: \n";
 	$auto_text .= "Telefono: \n";
 	$auto_text .= "Note: \n";
}

?>
<?php if(isset($this->error)) : ?>
<tr>
	<td><?php echo $this->error; ?></td>
</tr>
<?php endif; ?>
<tr>
	<td colspan="2">
	<br /><br />
	<form action="<?php echo JRoute::_( 'index.php' );?>" method="post" id="emailForm" class="form-validate">
		<div class="contact_email<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
			<label for="contact_name">
				&nbsp;<?php echo JText::_( 'Enter your name' );?>:
			</label>
			<br />
			<input type="text" name="name" id="contact_name" size="30" class="inputbox" value="" />
			<br />
			<label id="contact_emailmsg" for="contact_email">
				&nbsp;<?php echo JText::_( 'Email address' );?>:
			</label>
			<br />
			<input type="text" id="contact_email" name="email" size="30" value="" class="inputbox required validate-email" maxlength="100" />
			<br />
			<label for="contact_subject">
				&nbsp;<?php echo JText::_( 'Message subject' );?>:
			</label>
			<br />
			<input type="text" name="subject" id="contact_subject" size="30" class="inputbox" value="<?php echo $auto_subject; ?>" />
			<br /><br />
			<label id="contact_textmsg" for="contact_text">
				&nbsp;<?php echo JText::_( 'Enter your message' );?>:
			</label>
			<br />
			<textarea cols="50" rows="10" name="text" id="contact_text" class="inputbox required"><?php echo $auto_text; ?></textarea>
			<?php if ($this->contact->params->get( 'show_email_copy' )) : ?>
			<br />
				<input type="checkbox" name="email_copy" id="contact_email_copy" value="1"  />
				<label for="contact_email_copy">
					<?php echo JText::_( 'EMAIL_A_COPY' ); ?>
				</label>
			<?php endif; ?>
			<br />
			<br />
			<button class="button validate" type="submit"><?php echo JText::_('Send'); ?></button>
		</div>
        <div>
            <input type="hidden" name="option" value="com_contact" />
            <input type="hidden" name="view" value="contact" />
            <input type="hidden" name="id" value="<?php echo $this->contact->id; ?>" />
            <input type="hidden" name="task" value="submit" />
            <?php echo JHTML::_( 'form.token' ); ?>
        </div>
	</form>
	<br />
	</td>
</tr>