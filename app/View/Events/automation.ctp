<div class="event index">
<h2>Automation</h2>
<p>Automation functionality is designed to automatically generate signatures for intrusion detection systems. To enable signature generation for a given attribute, Signature field of this attribute must be set to Yes.
Note that not all attribute types are applicable for signature generation, currently we only support NIDS signature generation for IP, domains, host names, user agents etc., and hash list generation for MD5/SHA1 values of file artifacts. Support for more attribute types is planned.
To to make this functionality available for automated tools an authentication key is used. This makes it easier for your tools to access the data without further form-based-authentiation.<br/>
<strong>Make sure you keep that key secret as it gives access to the entire database !</strong></p>
<p>Your current key is: <code><?php echo $me['authkey'];?></code>.
You can <?php echo $this->Html->link('reset', array('controller' => 'users', 'action' => 'resetauthkey', 'me'));?> this key.
</p>
<p style="color:red;">Since version 2.2 the usage of the authentication key in the url is deprecated. Instead, pass the auth key in an Authorization header in the request. The legacy option of having the auth key in the url is temporarily still supported but not recommended.</p>
<p>Please use the use the following header:<br />
<code>Authorization: <?php echo $me['authkey']; ?></code></p>
<h3>XML Export</h3>
<p>An automatic export of all events and attributes <small>(except file attachments)</small> is available under a custom XML format.</p>
<p>You can configure your tools to automatically download the following file:</p>
<pre><?php echo Configure::read('MISP.baseurl');?>/events/xml/download</pre>
<p>If you only want to fetch a specific event append the eventid number:</p>
<pre><?php echo Configure::read('MISP.baseurl');?>/events/xml/download/1</pre>
<p>The xml download also accepts two additional (optional) parameters: a boolean field that determines whether attachments should be encoded and a second parameter that controls the eligible tags. To include a tag in the results just write its names into this parameter. To exclude a tag prepend it with a '!'. You can also chain several tag commands together with the '&&' operator. Please be aware the colons (:) cannot be used in the tag search. Use semicolons instead (the search will automatically search for colons instead). For example, to include tag1 and tag2 but exclude tag3 you would use:</p>
<pre><?php echo Configure::read('MISP.baseurl');?>/events/xml/download/null/true/tag1&&tag2&&!tag3</pre>
<p>Also check out the <a href="/pages/display/doc/using_the_system#rest">User Guide</a> to read about the REST API.</p>
<p></p>
<h3>CSV Export</h3>
<p>An automatic export of attributes is available as CSV. Only attributes that are flagged "to_ids" will get exported.</p>
<p>You can configure your tools to automatically download the following file:</p>
<pre><?php echo Configure::read('MISP.baseurl');?>/events/csv/download/</pre>
<p>You can specify additional flags for CSV exports as follows::</p>
<pre><?php echo Configure::read('MISP.baseurl');?>/events/csv/download/[event_id]/[ignore_ids_signatures_only_rule]/[tags]/[type]</pre>
<p>For example, to only download a csv generated of the "domain" type and the "Network Activity" category attributes all events except for the one and further restricting it to events that are tagged "tag1" or "tag2" but not "tag3", only allowing attributes that are IDS flagged use the following syntax:</p>
<pre><?php echo Configure::read('MISP.baseurl');?>/events/csv/download/0/0/tag1&&tag2&&!tag3/Network%20Activity/domain</pre>
<p>To export the attributes of all events that are of the type "domain", use the following syntax:</p>
<pre><?php echo Configure::read('MISP.baseurl');?>/events/csv/download/0/0/null/null/domain</pre>
<h3>NIDS rules export</h3>
<p>Automatic export of all network related attributes is available under the Snort rule format. Only <em>published</em> events and attributes marked as <em>IDS Signature</em> are exported.</p>
<p>You can configure your tools to automatically download the following file:</p>
<pre><?php echo Configure::read('MISP.baseurl');?>/events/nids/suricata/download
<?php echo Configure::read('MISP.baseurl');?>/events/nids/snort/download</pre>
<p>In addition to the above mentioned, the NIDS exports can accept several additional parameters: an event ID to only create the signature based on a single event (null will still include every event), a boolean flag that determines whether it should be a standalone file with all the descriptions at the start (false) or whether it should just be the signature lines (true). The last parameter is the tagging syntax, as described for the XML export. Please be aware the colons (:) cannot be used in the tag search. Use semicolons instead (the search will automatically search for colons instead). An example for a suricata export for all events excluding those tagged tag1, without all of the commented information at the start of the file would look like this:</p>
<pre><?php echo Configure::read('MISP.baseurl');?>/events/nids/suricata/download/null/true/!tag1</pre>
<p>Administration is able to maintain a white-list containing host, domain name and IP numbers to exclude from the NIDS export.</p>

<h3>Hash database export</h3>
<p>Automatic export of MD5/SHA1 checksums contained in file-related attributes. This list can be used to feed forensic software when searching for suspicious files. Only <em>published</em> events and attributes marked as <em>IDS Signature</em> are exported.</p>
<p>You can configure your tools to automatically download the following files:</p>
<h4>md5</h4>
<pre><?php echo Configure::read('MISP.baseurl');?>/events/hids/md5/download</pre>
<h4>sha1</h4>
<pre><?php echo Configure::read('MISP.baseurl');?>/events/hids/sha1/download</pre>
<p>You can also use the tag syntax similar to the XML import. Please be aware the colons (:) cannot be used in the tag search. Use semicolons instead (the search will automatically search for colons instead). For example, to only show sha1 values from events tagged tag1, use:</p>
<pre><?php echo Configure::read('MISP.baseurl');?>/events/hids/sha1/download/tag1</pre>
<h3>STIX export</h3>
<p>You can export MISP events in Mitre's STIX format (to read more about STIX, click <a href="https://stix.mitre.org/">here</a>). The STIX XML export is currently very slow and can lead to timeouts with larger events or collections of events. The JSON return format does not suffer from this issue. Usage:</p>
<pre><?php echo Configure::read('MISP.baseurl');?>/events/stix/download</pre>
<p>Search parameters can be passed to the function via url parameters or by POSTing an xml or json object (depending on the return type). The following parameters can be passed to the STIX export tool: <code>id</code>, <code>withAttachments</code>, <code>tags</code>. Both <code>id</code> and <code>tags</code> can use the <code>&&</code> (and) and <code>!</code> (not) operators to build queries. Using the url parameters, the syntax is as follows:</p>
<pre><?php echo Configure::read('MISP.baseurl');?>/events/stix/download/[id]/[withAttachments]/[tags]</pre>
<h4>Various ways to narrow down the search results of the STIX export</h4>
<p>For example, to retrieve all events tagged "APT1" but excluding events tagged "OSINT" and excluding events #51 and #62 without any attachments:
<pre><?php echo Configure::read('MISP.baseurl');?>/events/stix/download/!51&&!62/false/APT1&&!OSINT</pre>
<p>To export the same events using a POST request use:</p>
<pre><?php echo Configure::read('MISP.baseurl');?>/events/stix/download.json</pre>
<p>Together with this JSON object in the POST message:</p>
<code>{"request": {"id":["!51","!62"],"tags":["APT1","!OSINT"]}}</code><br /><br />
<p>XML is automatically assumed when using the stix export:</p>
<pre><?php echo Configure::read('MISP.baseurl');?>/events/stix/download</pre>
<p>The same search could be accomplished using the following POSTed XML object (note that ampersands need to be escaped, or alternatively separate id and tag elements can be used): </p>
<code>&lt;request&gt;&lt;id&gt;!51&lt;/id&gt;&lt;id&gt;!62&lt;/id&gt;&lt;tags&gt;APT1&lt;/tags&gt;&lt;tags&gt;!OSINT&lt;/tags&gt;&lt;/request&gt;</code>
<h3>Text export</h3>
<p>An automatic export of all attributes of a specific type to a plain text file.</p>
<p>You can configure your tools to automatically download the following files:</p>
<pre>
<?php
foreach ($sigTypes as $sigType) {
	echo Configure::read('MISP.baseurl').'/attributes/text/download/'.$sigType . "\n";
}
?>
</pre>
<p>To restrict the results by tags, use the usual syntax. Please be aware the colons (:) cannot be used in the tag search. Use semicolons instead (the search will automatically search for colons instead). To get ip-src values from events tagged tag1 but not tag2 use:</p>
<pre>
<?php 
	echo Configure::read('MISP.baseurl').'/attributes/text/download/ip-src/tag1&&!tag2';
?>
</pre>

<p>As of version 2.3.38, it is possible to restrict the text exports on two additional flags. The first allows the user to restrict based on event ID, whilst the second is a boolean switch allowing non IDS flagged attributes to be exported. Additionally, choosing "all" in the type field will return all eligible attributes. </p>
<pre>
<?php 
	echo Configure::read('MISP.baseurl').'/attributes/text/download/[type]/[tags]/[event_id]/[ignore_to_ids_restriction]';
?>
</pre>
<p>For example, to retrieve all attributes for event #5, including non IDS marked attributes too, use the following line:</p>
<pre>
<?php 
	echo Configure::read('MISP.baseurl').'/attributes/text/download/all/null/5/true';
?>
</pre>

<h3>RESTful searches with XML result export</h3>
<p>It is possible to search the database for attributes based on a list of criteria. </p>
<p>To return an event with all of its attributes, relations, shadowAttributes, use the following syntax:</p>
<pre>
<?php
	echo Configure::read('MISP.baseurl').'/events/restSearch/download/[value]/[type]/[category]/[org]/[tag]/[quickfilter]';
?>
</pre>
<p>There is also a new flag called "quickfilter". Enabling this (by passing "1" as the argument) will make the search ignore all of the other arguments, except for the auth key and value. MISP will return an xml / json (depending on the header sent) of all events that have a sub-string match on value in the event info, event orgc, or any of the attribute value1 / value2 fields, or in the attribute comment. For example, to find any event with the term "red october" mentioned, use the following syntax (the example is shown as a POST request instead of a GET, which is highly recommended):</p>
<p>POST to:</p>
<pre>
<?php
	echo Configure::read('MISP.baseurl').'/events/restSearch/download';
?>
</pre>
<p>POST message payload (XML):</p>
<p><code>
&lt;request&gt;&lt;value&gt;red october&lt;/value&gt;&lt;searchall&gt;1&lt;/searchall&gt;&lt;/request&gt;
</code></p>
<p>POST message payload (json):</p>
<p><code>
{"request": {"value":"red october","searchall":1}}
</code></p>
<p>To just return a list of attributes, use the following syntax:</p>
<pre>
<?php
	echo Configure::read('MISP.baseurl').'/attributes/restSearch/download/[value]/[type]/[category]/[org]/[tag]';
?>
</pre>
<p>value, type, category and org are optional. It is possible to search for several terms in each category by joining them with the '&amp;&amp;' operator. It is also possible to negate a term with the '!' operator. Please be aware the colons (:) cannot be used in the tag search. Use semicolons instead (the search will automatically search for colons instead).
For example, in order to search for all attributes created by your organisation that contain 192.168 or 127.0 but not 0.1 and are of the type ip-src, excluding the events that were tagged tag1 use the following syntax:</p>
<pre>
<?php
	echo Configure::read('MISP.baseurl').'/attributes/restSearch/download/192.168&&127.0&&!0.1/ip-src/null/' . $me['org'] . '/!tag1';
?>
</pre>
<p>You can also use search for IP addresses using CIDR. Make sure that you use '|' (pipe) instead of '/' (slashes). Please be aware the colons (:) cannot be used in the tag search. Use semicolons instead (the search will automatically search for colons instead). See below for an example: </p>
<pre>
<?php
	echo Configure::read('MISP.baseurl').'/attributes/restSearch/download/192.168.1.1|16/ip-src/null/' . $me['org'];
?>
</pre>
<h3>Export attributes of event with specified type as XML</h3>
<p>If you want to export all attributes of a pre-defined type that belong to an event, use the following syntax:</p>
<pre>
<?php
	echo Configure::read('MISP.baseurl').'/attributes/returnAttributes/download/[id]/[type]/[sigOnly]';
?>
</pre>
<p>sigOnly is an optional flag that will block all attributes from being exported that don't have the IDS flag turned on.
It is possible to search for several types with the '&amp;&amp;' operator and to exclude values with the '!' operator.
For example, to get all IDS signature attributes of type md5 and sha256, but not filename|md5 and filename|sha256 from event 25, use the following: </p>
<pre>
<?php
	echo Configure::read('MISP.baseurl').'/attributes/returnAttributes/download/25/md5&&sha256&&!filename/true';
?>
</pre>

<h3>Download attachment or malware sample</h3>
<p>If you know the attribute ID of a malware-sample or an attachment, you can download it with the following syntax:</p>
<pre>
<?php
	echo Configure::read('MISP.baseurl').'/attributes/downloadAttachment/download/[Attribute_id]';
?>
</pre>
</div>
<?php 
	echo $this->element('side_menu', array('menuList' => 'event-collection', 'menuItem' => 'automation'));
?>
