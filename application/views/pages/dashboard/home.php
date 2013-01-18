<? function statusToString($i) { 
		if($i == 0) { 
			return "Failed";
		} 
		if($i == 1) { 
			return "Success";
		} 
		if($i == 2) { 
			return "Success with error";
		}
	}
?>					<div class="row-fluid">
                        <div class="span9">
							<div class="heading clearfix">
								<h3 class="pull-left">Latest Logs</h3>
							</div>
							<table class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>id</th>
										<th>Thread Title</th>
										<th>Bot Name</th>
										<th>Status</th>
										<th>Timestamp</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<? for($i=0;$i<count($logs);$i++) { ?>
									<tr>
										<td><?=$logs[$i]['id'];?></td>
										<td><?=$logs[$i]['thread_title'];?></td>
										<td><?=$logs[$i]['bot_name'];?></td>
										<td><?=statusToString($logs[$i]['result']);?></td>
										<td><?=$logs[$i]['timestamp'];?></td>
										<td>
											<a href="#" title="Edit"><i class="splashy-document_letter_edit"></i></a>
											<a href="#" title="Accept"><i class="splashy-document_letter_okay"></i></a>
											<a href="#" title="Remove"><i class="splashy-document_letter_remove"></i></a>
										</td>
									</tr>
								<? } ?>
																
							
									<tr>
										<td>133</td>
										<td>Declan Pamphlett</td>
										<td>Pending</td>
										<td>23/04/2012</td>
										<td>$320.00</td>
										<td>
											<a href="#" title="Edit"><i class="splashy-document_letter_edit"></i></a>
											<a href="#" title="Accept"><i class="splashy-document_letter_okay"></i></a>
											<a href="#" title="Remove"><i class="splashy-document_letter_remove"></i></a>
										</td>
									</tr>
									<tr>
										<td>132</td>
										<td>Erin Church</td>
										<td>Pending</td>
										<td>23/04/2012</td>
										<td>$44.00</td>
										<td>
											<a href="#" title="Edit"><i class="splashy-document_letter_edit"></i></a>
											<a href="#" title="Accept"><i class="splashy-document_letter_okay"></i></a>
											<a href="#" title="Remove"><i class="splashy-document_letter_remove"></i></a>
										</td>
									</tr>
									<tr>
										<td>131</td>
										<td>Koby Auld</td>
										<td>Pending</td>
										<td>22/04/2012</td>
										<td>$180.20</td>
										<td>
											<a href="#" title="Edit"><i class="splashy-document_letter_edit"></i></a>
											<a href="#" title="Accept"><i class="splashy-document_letter_okay"></i></a>
											<a href="#" title="Remove"><i class="splashy-document_letter_remove"></i></a>
										</td>
									</tr>
									<tr>
										<td>130</td>
										<td>Anthony Pound</td>
										<td>Pending</td>
										<td>20/04/2012</td>
										<td>$610.42</td>
										<td>
											<a href="#" title="Edit"><i class="splashy-document_letter_edit"></i></a>
											<a href="#" title="Accept"><i class="splashy-document_letter_okay"></i></a>
											<a href="#" title="Remove"><i class="splashy-document_letter_remove"></i></a>
										</td>
									</tr>
								</tbody>
							</table>
                        </div>
						<div class="span3" id="user-list">
							<h3 class="heading">Bot Status </h3>
							<ul class="list user_list">
								<? for($i=0;$i<count($user_bots);$i++) { ?>
								<li>
									<span class="label label-warning pull-right sl_status">ping</span>
									<a href="#" class="sl_name"><?=$user_bots[$i]['username'];?></a><br />
									<small class="s_color sl_email">last checked: {date}</small>
								</li>
								<? } ?>
								
								
							</ul>
							<div class="pagination"><ul class="paging bottomPaging"></ul></div>
                        </div>
                    </div>
                        
                    <div class="row-fluid">
                        <div class="span12">
							<h3 class="heading">Thread Calendar</h3>
							<div id="calendar"></div>
                        </div>
						</div>
                        
					</div>
            