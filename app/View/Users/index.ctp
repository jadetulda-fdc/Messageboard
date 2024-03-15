<?php
$this->assign('title', 'MessageBoard');
$this->assign('page_header', 'Dashboard');
?>

<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th>ID</th>
				<th>Email</th>
				<th>Password</th>
				<th>Last Logged In</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($users as $user) {
				$row = $user['User'];
			?>
				<tr>
					<td><?php echo $row['id']; ?></td>
					<td><?php echo $row['email']; ?></td>
					<td><?php echo $row['password']; ?></td>
					<td><?php echo $row['last_login_time']; ?></td>
				</tr>
			<?php
			}
			?>
		</tbody>
	</table>
</div>