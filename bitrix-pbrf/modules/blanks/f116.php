<?php $data = $GLOBALS["blank"]	; ?>
		<tr>
			<td width="40%">
				<label for="from_surname"><?= GetMessage("FROM_SURNAME"); ?>:</label>
			</td>
			<td width="60%">
				<input id="from_surname" type="text" name="from_surname" value="<?= $data["from_surname"]; ?>" size="40">
			</td>
		</tr>
		<tr>
			<td width="40%">
				<label for="from_country"><?= GetMessage("FROM_COUNTRY"); ?>:</label>
			</td>
			<td width="60%">
				<input id="from_country" type="text" name="from_country" value="<?= $data["from_country"]; ?>" size="20">
			</td>
		</tr>
		<tr>
			<td width="40%">
				<label for="from_city"><?= GetMessage("FROM_CITY"); ?>:</label>
			</td>
			<td width="60%">
				<input id="from_city" type="text" name="from_city" value="<?= $data["from_city"]; ?>" size="20">
			</td>
		</tr>
		<tr>
			<td width="40%">
				<label for="from_street"><?= GetMessage("FROM_STREET"); ?>:</label>
			</td>
			<td width="60%">
				<input id="from_street" type="text" name="from_street" value="<?= $data["from_street"]; ?>" size="40">
			</td>
		</tr>		
		<tr>
			<td width="40%">
				<label for="from_zip"><?= GetMessage("FROM_ZIP"); ?>:</label>
			</td>
			<td width="60%">
				<input id="from_zip" type="text" name="from_zip" value="<?= $data["from_zip"]; ?>" size="10" maxlength="6">
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td width="40%">
				<label for="document"><?= GetMessage("DOCUMENT_NAME"); ?>:</label>
			</td>
			<td width="60%">
				<input id="document" type="text" name="document" value="<?= $data["document"]; ?>" size="20">
			</td>
		</tr>
		<tr>
			<td width="40%">
				<label for="document_serial"><?= GetMessage("DOCUMENT_SERIAL"); ?>:</label>
			</td>
			<td width="60%">
				<input id="document_serial" type="text" name="document_serial" value="<?= $data["document_serial"]; ?>" size="10">
			</td>
		</tr>
		<tr>
			<td width="40%">
				<label for="document_number"><?= GetMessage("DOCUMENT_NUMBER"); ?>:</label>
			</td>
			<td width="60%">
				<input id="document_number" type="text" name="document_number" value="<?= $data["document_number"]; ?>" size="10">
			</td>
		</tr>
		<tr>
			<td width="40%">
				<label for="document_day"><?= GetMessage("DOCUMENT_DAY"); ?>:</label>
			</td>
			<td width="60%">
				<input id="document_day" type="text" name="document_day" value="<?= $data["document_day"]; ?>" size="5">
			</td>
		</tr>
		<tr>
			<td width="40%">
				<label for="document_year"><?= GetMessage("DOCUMENT_YEAR"); ?>:</label>
			</td>
			<td width="60%">
				<input id="document_year" type="text" name="document_year" value="<?= $data["document_year"]; ?>" size="5">
			</td>
		</tr>
		<tr>
			<td width="40%">
				<label for="document_issued_by"><?= GetMessage("DOCUMENT_ISSUED_BY"); ?>:</label>
			</td>
			<td width="60%">
				<input id="document_issued_by" type="text" name="document_issued_by" value="<?= $data["document_issued_by"]; ?>" size="30">
			</td>
		</tr>