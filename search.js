/*********************************************************
 *
 *
 * Javascript functions for loading and searching
 *
 *
 **********************************************************/

 	
/*
 * function to add to favorites list and display on a side bar in search.php
 */
 
function adfav(orgname)
{
	// perform xmlhttprequests
	if ( window.XMLHttpRequest )
		xmlhttp = new XMLHttpRequest();
	else
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	
	xmlhttp.onreadystatechange = function()
	{
		// output results of the query to the HTML
		document.getElementById("favs").innerHTML = xmlhttp.responseText;
	}
	// send organization name to addfavs.php
	xmlhttp.open("GET", "addfavs.php?q="+escape(orgname), true);
	xmlhttp.send();
}
	
/*
 * function to check and uncheck the "Any" boxes anytime the user clicks on that box
 */
 
function checkcat(checkedbox) 
{
	// check if the "Any" box under the organization sizes is the one clicked 
	if ( checkedbox == "anynumber" )
		// if true, turn other boxes off
		if ( document.keyword.anynumber.checked == true )
			for ( var i = 0; i < document.keyword.number.length; i++ )
				document.keyword.number[i].checked = false;
	
	// check if any other box besides "Any" is checked and uncheck "Any"
	if ( checkedbox == "number" )
		document.keyword.anynumber.checked = false;
		
	// check if the "Any" box under the organization categories is the one clicked 
	if ( checkedbox == "anycategory" )
		// if true, turn other boxes off
		if ( document.keyword.anycategory.checked == true )
			for ( var i = 0; i < document.keyword.category.length; i++ )
				document.keyword.category[i].checked = false;
				
	// check if any other box besides "Any" is checked and uncheck "Any"	
	if ( checkedbox == "category" )
		document.keyword.anycategory.checked = false;
	// redo the search
	wait();
}
 
/*
 * function to drop down information after user clicks on an organization's name in search.php
 */

function dropdown(name)
{
	// loop through organizations
	for ( var i = 0; i < ORGANIZATIONS.length; i++ )
	{
		// add information in html tag of the organization if the name and organization matches
		if ( name == ORGANIZATIONS[i].GroupTitle )
		{
			document.getElementById(escape(name)).innerHTML = "<p id='orgname'><a href='javascript: dropup(&#39;"+escape(ORGANIZATIONS[i].GroupTitle)+"&#39;)'>"+ORGANIZATIONS[i].GroupTitle+"</a></p><p id='orgpurpose'>Purpose: "+ORGANIZATIONS[i].PurposeStatement+"</p><p id='orgcats'>Categories: "+ORGANIZATIONS[i].AssociatedCategories+"</p><p id='orgsize'>Size: "+ORGANIZATIONS[i].NumberofMembers+" members</p><p id='orginvolve'>Involvement: "+ORGANIZATIONS[i].Involvement+"</p><p id='orgemail'>Group Email: <a href='mailto:"+ORGANIZATIONS[i].GroupEmail+"'>"+ORGANIZATIONS[i].GroupEmail+"</a></p><p id='orgsite'>Group Website: <a href='"+ORGANIZATIONS[i].GroupWebsite+"' target='_blank'>"+ORGANIZATIONS[i].GroupWebsite+"</a></p><p id='elections'>Month of Elections: "+ORGANIZATIONS[i].MonthofOfficerElections+"</p><p id='lastupdate'>Information Last Updated: "+ORGANIZATIONS[i].InformationLastUpdated+"</p><p>Favorite: <a href='javascript: adfav(&#39;"+escape(ORGANIZATIONS[i].GroupTitle)+"&#39;)'>Add to Favorites</a></p>";
			break;
		}
	}
}

/*
 * function to drop down information after user clicks on an organization's name in favorites.php
 */

function dropdownfav(name)
{
	// loop through organizations
	for ( var i = 0; i < ORGANIZATIONS.length; i++ )
	{
		// add information in html tag of the organization if the name and organization matches
		if ( name == ORGANIZATIONS[i].GroupTitle )
		{
			document.getElementById(escape(name)).innerHTML = "<p id='orgname'><a href='javascript: dropupfav(&#39;"+escape(ORGANIZATIONS[i].GroupTitle)+"&#39;)'>"+ORGANIZATIONS[i].GroupTitle+"</a></p><p id='orgpurpose'>Purpose: "+ORGANIZATIONS[i].PurposeStatement+"</p><p id='orgcats'>Categories: "+ORGANIZATIONS[i].AssociatedCategories+"</p><p id='orgsize'>Size: "+ORGANIZATIONS[i].NumberofMembers+" members</p><p id='orginvolve'>Involvement: "+ORGANIZATIONS[i].Involvement+"</p><p id='orgemail'>Group Email: <a href='mailto:"+ORGANIZATIONS[i].GroupEmail+"'>"+ORGANIZATIONS[i].GroupEmail+"</a></p><p id='orgsite'>Group Website: <a href='"+ORGANIZATIONS[i].GroupWebsite+"' target='_blank'>"+ORGANIZATIONS[i].GroupWebsite+"</a></p><p id='elections'>Month of Elections: "+ORGANIZATIONS[i].MonthofOfficerElections+"</p><p id='lastupdate'>Information Last Updated: "+ORGANIZATIONS[i].InformationLastUpdated+"</p><p>Favorite: <a href='javascript: rmfav(&#39;"+escape(ORGANIZATIONS[i].GroupTitle)+"&#39;)'>Remove from Favorites</a></p>";
			break;
		}
	}
}


/*
 * function to minimize information after user clicks on an organization's name in search.php
 */
 
function dropup(name)
{
	// loop through organizations
	for ( var i = 0; i < ORGANIZATIONS.length; i++ )
	{
		// if match, then replace html
		if ( name == ORGANIZATIONS[i].GroupTitle )
		{
			document.getElementById(escape(name)).innerHTML = "<p id='orgname'><a href='javascript: dropdown(&#39;"+escape(ORGANIZATIONS[i].GroupTitle)+"&#39;)'>"+ORGANIZATIONS[i].GroupTitle+"</a></p>";
			break;
		}
	}
	
}

/*
 * function to minimize information after user clicks on an organization's name in favorites.php
 */
 
function dropupfav(name)
{
	// loop through organizations
	for ( var i = 0; i < ORGANIZATIONS.length; i++ )
	{
		if ( name == ORGANIZATIONS[i].GroupTitle )
		{
			// if match, then replace html
			document.getElementById(escape(name)).innerHTML = "<p id='orgname'><a href='javascript: dropdownfav(&#39;"+escape(ORGANIZATIONS[i].GroupTitle)+"&#39;)'>"+ORGANIZATIONS[i].GroupTitle+"</a></p>";
			break;
		}
	}
	
}

/*
 * function to remove organization from database
 */
 
function rmfav(orgname)
{
	// perform xmlhttprequest
	if ( window.XMLHttpRequest )
		xmlhttp = new XMLHttpRequest();
	else
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	
	xmlhttp.onreadystatechange = function()
	{
		// delay slightly to allow information to go through, then refresh
		setTimeout("location.reload(true)",250);
	}
	// call rmfavs.php to perform query to remove the said organization from favorites
	xmlhttp.open("GET", "rmfavs.php?q="+escape(orgname), true);
	xmlhttp.send();
}

/*
 * Search function to search for organizations and display them on the page
 */

function searching()
{
	// take value from search box and convert to lowercase
	var searchterm = document.keyword.query.value.toLowerCase();
	// escape for safety
	searchterm = escape(searchterm);
	// initiate search to null to check against later
	var searchResult = "";
	
	// loop through conditions to find organization
	for ( var i = 0; i < ORGANIZATIONS.length; i++ )
	{	
		// boolean variable to check to tell if variable fits under any of the checked boxes
		var checkboxes = false;
		// if the "Any" box is checked, skip the matching of organization size
		if ( document.keyword.anynumber.checked )
			// match automatically found due to "Any"
			checkboxes = true;
		// loop through checkboxes to see if any matches exist
		else
			for ( var j = 0; j < document.keyword.number.length; j++ )
				if ( document.keyword.number[j].checked && document.keyword.number[j].value == ORGANIZATIONS[i].NumberofMembers )
					// true if matches
					checkboxes = true;
		
		// if no matches, go onto the next organizations
		if ( checkboxes == false )
			continue;
		
		// reset boolean variable
		checkboxes = false;
		
		// if the "Any" box is checked, skip the matching of organization categories 
		if ( document.keyword.anycategory.checked )
			// match automatically found due to "Any"
			checkboxes = true;
		else
			// loop through checkboxes to see if any matches exist
			for ( var j = 0; j < document.keyword.category.length; j++ )
				if ( document.keyword.category[j].checked && escape(ORGANIZATIONS[i].AssociatedCategories.toLowerCase()).search(escape(document.keyword.category[j].value.toLowerCase())) != -1 )
					// true if matches
					checkboxes = true;
					
		// if no matches, go onto the next organizations	
		if ( checkboxes == false )
			continue;
		
		// boolean variable to check for matches from search bar
		var x = false;
		
		// use javascript search() function to search for characters and strings after putting everything in lower case and escaping
		if ( escape(ORGANIZATIONS[i].GroupTitle.toLowerCase()).search(searchterm) != -1 )
			x = true;
		else if ( escape(ORGANIZATIONS[i].PurposeStatement.toLowerCase()).search(searchterm) != -1 )
			x = true;
		else if ( escape(ORGANIZATIONS[i].AssociatedCategories.toLowerCase()).search(searchterm) != -1 )
			x = true;
		else if ( escape(ORGANIZATIONS[i].NumberofMembers.toLowerCase()).search(searchterm) != -1 )
			x = true;
		else if ( escape(ORGANIZATIONS[i].GroupWebsite.toLowerCase()).search(searchterm) != -1 )
			x = true;
		else if ( escape(ORGANIZATIONS[i].MonthofOfficerElections.toLowerCase()).search(searchterm) != -1 )
			x = true;
		else if ( escape(ORGANIZATIONS[i].InformationLastUpdated.toLowerCase()).search(searchterm) != -1 )
			x = true;
		
		// if user didn't type anything, assume "Any", so display all given checkboxes
		if ( searchterm == "" )
			x = true;
		
		// if the term checks out, then add string to searchResults, which is formatted with tags to be used in document.getElementById().innerHTML
		if ( x == true )
		{
			searchResult += "<tr><td id='"+escape(ORGANIZATIONS[i].GroupTitle)+"'><p id='orgname'><a href='javascript:dropdown(&#39;"+escape(ORGANIZATIONS[i].GroupTitle)+"&#39;);'>"+ORGANIZATIONS[i].GroupTitle+"</a></p></td></tr>";
		}
	}
	
	// if nothing matches, tell user
	if ( searchResult == "" )
		searchResult += "<tr><td style='text-align: center'>No organizations matched your search term! Please try again!</td></tr>";
	
	// print results in HTML
	document.getElementById("results").innerHTML = searchResult;
}


/*
 * function used for a slight delay for query to register
 */

function wait()
{	
		// set delay so the value in the search box can be registered, then start search
		setTimeout("searching()",250);
}
