<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<b>Be sure to backup your database before use this plugin !</b>
<form action="" method="post" id="find-and-replace">
	<?php wp_nonce_field( 'find_replace' ) ?>
	<label for="s">Find :</label><input type="text" name="s" id="s" /><br />
	<label for="r">Replace by :</label><input type="text" name="r" id="r" /><br />
	<label for="in">In : </label>
	<input type="checkbox" value="post" name="post" /> Posts 
	<input type="checkbox" value="page" name="page" /> Pages<br />
	<input type="submit" value="Go !" />
</form>
