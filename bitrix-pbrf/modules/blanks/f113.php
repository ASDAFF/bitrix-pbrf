<?php $data = $GLOBALS["blank"]	; ?>
		<tr>
			<td width="40%">
				<label for="to_surname"><?= GetMessage("TO_SURNAME"); ?>:</label>
			</td>
			<td width="60%">
				<input id="to_surname" type="text" name="to_surname" value="<?= $data["to_surname"]; ?>" size="40">
			</td>
		</tr>
		<tr>
			<td width="40%">
				<label for="to_region"><?= GetMessage("TO_REGION"); ?>:</label>
			</td>
			<td width="60%">
				<input id="to_region" type="text" name="to_region" value="<?= $data["to_region"]; ?>" size="20">
			</td>
		</tr>
		<tr>
			<td width="40%">
				<label for="to_city"><?= GetMessage("TO_CITY"); ?>:</label>
			</td>
			<td width="60%">
				<input id="to_city" type="text" name="to_city" value="<?= $data["to_city"]; ?>" size="20">
			</td>
		</tr>
		<tr>
			<td width="40%">
				<label for="to_street"><?= GetMessage("TO_STREET"); ?>:</label>
			</td>
			<td width="60%">
				<input id="to_street" type="text" name="to_street" value="<?= $data["to_street"]; ?>" size="20">
			</td>
		</tr>
		<tr>
			<td width="40%">
				<label for="to_build"><?= GetMessage("TO_BUILD"); ?>:</label>
			</td>
			<td width="60%">
				<input id="to_build" type="text" name="to_build" value="<?= $data["to_build"]; ?>" size="20">
			</td>
		</tr>
		<tr>
			<td width="40%">
				<label for="to_zip"><?= GetMessage("TO_ZIP"); ?>:</label>
			</td>
			<td width="60%">
				<input id="to_zip" type="text" name="to_zip" value="<?= $data["to_zip"]; ?>" size="7" maxlength="6">
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>		
		<tr>
			<td width="40%">
				<label for="inn"><?= GetMessage("INN"); ?>:</label>
			</td>
			<td width="60%">
				<input id="inn" type="text" name="inn" value="<?= $data["inn"]; ?>" size="10" maxlength="12">
			</td>
		</tr>
		<tr>
			<td width="40%">
				<label for="kor_account"><?= GetMessage("KOR_ACCOUNT"); ?>:</label>
			</td>
			<td width="60%">
				<input id="kor_account" type="text" name="kor_account" value="<?= $data["kor_account"]; ?>" size="20" maxlength="20">
			</td>
		</tr>
		<tr>
			<td width="40%">
				<label for="current_account"><?= GetMessage("CURRENT_ACCOUNT"); ?>:</label>
			</td>
			<td width="60%">
				<input id="current_account" type="text" name="current_account" value="<?= $data["current_account"]; ?>" size="20" maxlength="20">
			</td>
		</tr>
		<tr>
			<td width="40%">
				<label for="bik"><?= GetMessage("BIK"); ?>:</label>
			</td>
			<td width="60%">
				<input id="bik" type="text" name="bik" value="<?= $data["bik"]; ?>" size="10" maxlength="9">
			</td>
		</tr>
		<tr>
			<td width="40%">
				<label for="bank_name"><?= GetMessage("BANK_NAME"); ?>:</label>
			</td>
			<td width="60%">
				<input id="bank_name" type="text" name="bank_name" value="<?= $data["bank_name"]; ?>" size="30">
			</td>
		</tr>