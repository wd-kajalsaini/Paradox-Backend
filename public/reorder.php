<!---Header Start-->
<?php include('header.php'); ?>
<!---HeaderEnd-->
<!---TopNavbar Start-->
<?php include('topNavbar.php'); ?>
<!---TopNavbar End-->
<!---Side Bar Start-->
<?php include('sidebar.php'); ?>
<!---Side Bar End-->
      <!-- Main section-->
      <section  id="sectionManager"class="section-container">
         <!-- Page content-->
         <div class="content-wrapper">
            <div class="content-heading px-4">
               <div>System/System Section/Reoder</div>
              <div class="ml-auto">
                        <button class="btn btn-primary btn-lg theme-btn" type="button" onclick="goBack()">Back</button>
               </div><!--- END Language list--->
            </div><!-- START cards box-->

               <div class="card card-transparent p-2" role="tabpanel">
                  
            <div class="container-fluid">
               <div class="js-nestable-action"> 

                  <a class="btn btn-secondary btn-sm mr-1" id="expandAll">Expand All</a>
                  <a class="btn btn-secondary btn-sm" id="collapseAll">CollapseAll</a>
               </div>
                       <div class="row">                  
                
                  <div class="col-lg-6 mt-3">


             
                      <div class="row">
                     <div class="col-md-12 col-sm-12">
                         <div class="sections-box first-section">
                             <div class="panel-group panel-daggable ui-sortable" id="accordion">
                                 <div class="panel panel-default ">
                                     <a data-toggle="collapse" data-parent="#accordion" href="#collapse1"><div class="panel-heading">                                         
                                         <p class="pl-2 mb-0"> <em class="fas fa-bars fa-fw text-muted mr-2"></em>
                                          <span class="navTitle">  Dashobard</span></p>
                                     </div></a>
                                     <div id="collapse1" class="panel-collapse collapse ">
                                         <div class="panel-body">
                                             <div class="row sortList">
                                                 <div class="col-sm-12">
                                                     <p class="pl-2 mb-0 subList"> <em class="fas fa-bars fa-fw text-muted mr-2"></em>
                                                       <span class="navTitle">Dashobard 1</span></p>
                                                 </div>
                                                 <div class="col-sm-12">
                                                    <p class="pl-2 mb-0 subList"> <em class="fas fa-bars fa-fw text-muted mr-2"></em>
                                                   <span class="navTitle">Dashobard 2</span></p>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>

                                 <div class="panel panel-default ui-sortable-handle">
                                     <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                                     <div class="panel-heading">                                         
                                         <p class="pl-2 mb-0"> <em class="fas fa-bars fa-fw text-muted mr-2"></em>
                                          <span class="navTitle">Techincal</span></p></div>
                                  </a> 
                                     <div id="collapse2" class="panel-collapse collapse allCollpsehide">
                                         <div class="panel-body">
                                               <div class="panel-group panel-daggable ui-sortable" id="accordion">
                                              <div class="panel panel-default">
                                                 <a data-toggle="collapse" data-parent="#accordion" href="#collapse2-1-1">
                                                    <div class="panel-heading">                                         
                                         <p class="pl-2 mb-0"> <em class="fas fa-bars fa-fw text-muted mr-2"></em>
                                          <span class="navTitle">Techincal1</span></p></div></a>
                                                 <div id="collapse2-1-1" class="panel-collapse collapse allCollpsehide">
                                                     <div class="panel-body">
                                                           <div class="row sortList">
                                                             <div class="col-sm-12">
                                                                <p class="pl-2 mb-0 subList"> <em class="fas fa-bars fa-fw text-muted mr-2"></em>
                                                               <span class="navTitle">Techincal1.1</span></p>                                                                
                                                              </div>
                                                             <div class="col-sm-12">
                                                                <p class="pl-2 mb-0 subList"> <em class="fas fa-bars fa-fw text-muted mr-2"></em>
                                                               <span class="navTitle">Techincal1.2</span></p>                                                                
                                                              </div>
                                                          </div>
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="panel panel-default">
                                                 <a data-toggle="collapse" data-parent="#accordion" href="#collapse2.2"> <div class="panel-heading">                                         
                                         <p class="pl-2 mb-0"> <em class="fas fa-bars fa-fw text-muted mr-2"></em>
                                          <span class="navTitle">Techincal 2</span></p></div></a>                                                 
                                             </div>
                                          </div>
                                         </div>
                                     </div>
                                 </div>
                                 <!-- panel Closed -->
                                  <div class="panel panel-default">
                                     <a data-toggle="collapse" data-parent="#accordion" href="#collapse3"> <div class="panel-heading">                                         
                                         <p class="pl-2 mb-0"> <em class="fas fa-bars fa-fw text-muted mr-2"></em>
                                          <span class="navTitle">Application</span></p></div></a>
                                 </div>
                                 <!-- panel Closed -->
                             </div>
                         </div>
                     </div>
        </div>
                  </div>
               </div>     
               </div>
         </div>
      </section>
<!---Footer Start-->

<?php include('footer.php'); ?>  
<!---Footer End-->


