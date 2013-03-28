<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html"  encoding="UTF-8"/>
	<xsl:template match="/">
		<html>
			<head>
				<title>Joomla! CMS PHPCS Results</title>
				<link href="media/jui/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
				<script src="media/jui/js/jquery.min.js" type="text/javascript" />
				<script src="media/jui/js/bootstrap.min.js" type="text/javascript" />
				<script>$(document).ready(function() {
					$('.btn-group.type-filter')
					.show()
					.find('button')
					.find('i').click(function(){ $(this).parent().click(); });

					$('.type-filter button.error').click(function() {
						$('div.error').toggle($(this).hasClass('active'));
					});
					$('.type-filter button.warning').click(function() {
						$('div.warning').toggle($(this).hasClass('active'));
					});
				});
				</script>
			</head>
			<body>
				<div class="container">
					<h2 class="page-header">Joomla! CMS Codestyle Test Results</h2>
					<div>
						<div class="pull-right">
							<div class="nav-header">Filter Options</div>
							<div class="btn-group type-filter active" data-toggle="buttons-checkbox" data-original-title="" style="display: block;">
								<button class="btn error">Error</button>
								<button class="btn warning">Warning</button>
							</div>
						</div>
						<p>This is the result of the codestyle checker with all exceptions removed.  It is designed to aide in bringing the CMS in compliance with the Joomla! Coding Standard.</p>
						<p><span class="badge">Note</span> Because this is rendered as a XML document with a XSL template, it will take a while to fully load.</p>
					</div>
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Name</th>
								<th>Errors</th>
								<th>Warnings</th>
							</tr>
						</thead>
						<tbody>
							<xsl:for-each select="phpcs/file">
								<tr>
									<td>
										<xsl:value-of select="@name" />
									</td>
									<td>
										<span class="badge badge-important"><xsl:value-of select="@errors" /></span>
									</td>
									<td>
										<span class="badge badge-warning"><xsl:value-of select="@warnings" /></span>
									</td>
								</tr>
								<tr>
									<td colspan="3">
										<xsl:for-each select="error">
											<div class="error">
												<table class="table table-striped table-bordered table-condensed">
													<tr>
														<td colspan="2">
															<span class="badge badge-important">Error</span> <xsl:value-of select="self::node()"/>
														</td>
													</tr>
													<tr>
														<td><b>Line:</b></td>
														<td><xsl:value-of select="@line" /></td>
													</tr>
													<tr>
														<td><b>Column:</b></td>
														<td><xsl:value-of select="@column" /></td>
													</tr>
													<tr>
														<td><b>Source:</b></td>
														<td><xsl:value-of select="@source" /></td>
													</tr>
												</table>
											</div>
										</xsl:for-each>
										<xsl:for-each select="warning">
											<div class="warning">
												<table class="table table-striped table-bordered table-condensed">
													<tr>
														<td colspan="2">
															<span class="badge badge-warning">Warning</span> <xsl:value-of select="self::node()"/>
														</td>
													</tr>
													<tr>
														<td><b>Line:</b></td>
														<td><xsl:value-of select="@line" /></td>
													</tr>
													<tr>
														<td><b>Column:</b></td>
														<td><xsl:value-of select="@column" /></td>
													</tr>
													<tr>
														<td><b>Source:</b></td>
														<td><xsl:value-of select="@source" /></td>
													</tr>
												</table>
											</div>
										</xsl:for-each>
									</td>
								</tr>
							</xsl:for-each>
						</tbody>
					</table>
				</div>
			</body>
		</html>
	</xsl:template>

</xsl:stylesheet>
