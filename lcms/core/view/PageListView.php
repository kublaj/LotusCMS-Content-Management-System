<?php
include("core/lib/table.php");

class PageListView extends View{
	
	public function PageListView(){
		//Meta is usually not setup yet, so we manually do this before loading css file
		$this->meta = new Meta();
		
		//This class requires an extra css file
		$this->getMeta()->addExtra('<link href="core/fragments/css/admin.css" rel="stylesheet" type="text/css" />');
		
		//This js is for the filtering of the pagelist
		$this->getMeta()->addExtra('<script type="text/javascript" src="core/fragments/js/application.js"></script>');
	}	
	
	/**
	 * Shows a list of the pages 
	 */
	public function showPageList($pages){
		$this->setState('SHOWING_PAGE_LIST');
		
		//Get Top of pagelist
		$content = $this->openFile("core/fragments/admin_pagelist.phtml");
		
		//Set this tab active
		$content = $this->setTabActive(1, $content);
		
		$content = str_replace("%PAGELIST_LOCALE%", $this->localize("Existing Pages"), $content);
		$content = str_replace("%CREATE_NEW_PAGE_LOCALE%", $this->localize("Create New Page"), $content);
		$content = str_replace("%PAGE_TITLE_LOCALE%", $this->localize("LotusCMS Pages"), $content);
		$content = str_replace("%TYPE_FILTER_LOCALE%", $this->localize("Type here to filter results..."), $content);
		$content = str_replace("%NO_RESULTS_LOCALE%", $this->localize("No Results"), $content);
		$content = str_replace("%VIEW_LOCALE%", $this->localize("View"), $content);
		$content = str_replace("%EDIT_LOCALE%", $this->localize("Edit"), $content);
		$content = str_replace("%DELETE_LOCALE%", $this->localize("Delete"), $content);

		//Creates a list from the supplied data
		$content .= $this->createPageList($pages);
		
		//Ends the divider
		$content .= "</div>";
		
		//Print this dashboard
		$this->setContent($content);	
		$this->setContentTitle($this->localize("Pages"));
	}
	
	/**
	 * Changes an array of pagenames into a table with "edit", "view" and "delete" options
	 */
	protected function createPageList($data){
		$this->setState('CREATING_PAGE_LIST_TABLE');
		
		//Create new Table item
		$t = new Table();
		
		//Create new Table
		$t->createTable("Pagelist");
		
		//Sets that there is no heading row.
		$t->setHead(false);
		
		//Loop Through each page
		for($i = 0; $i < count($data); $i++)
		{
			//Add Page data for each row.
			$t->addRow(
					array(
						$data[$i],
						"<a href='?system=Editor&page=editor&active=".$data[$i]."'>".$this->localize("Edit")."</a>",
						"<a href='?page=".$data[$i]."'>".$this->localize("View")."</a>",
						"<a href='?system=Editor&page=delete&active=".$data[$i]."'>".$this->localize("Delete")."</a>",					
					)
				  );
		}
		
		//Creates a table from inserted data
		$t->runTable();
		
		//Returns the created table.
		return $t->getTable();
	}
}

?>