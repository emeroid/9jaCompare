@extends('layouts.master')

@section('content')

@include('layouts.inc.form')
<div id="contents" class="col-md-12">
    
   </div>
   
   </div>
   <div class="margin-bottom-60"></div>
 <h3 class=" heading-v1 text-center"> Your Compared Products</h3>
<div class="margin-bottom-60"></div>


<div class="col-sm-6">

<div class="container-fluid">
 <div class="margin-bottom-80"></div>
 					
              <div class="col-sm-8">
				<div class="tab-v2">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#spec" data-toggle="tab">Specification</a></li>
							<li><a href="#desc" data-toggle="tab">Description</a></li>
							<li><a href="#more" data-toggle="tab">More Info</a></li>
						</ul>
                        </div>
                        
						<div class="col-sm-8">
                        <img class="img-center img-responsive"  src="content" alt="">
                        
                        <div class="margin-bottom-20"></div>
                        
							<div class="tab-pane tab-content">
								<div class="tab-pane fade in active one" id="spec">
									content
							</div>
								<div class="tab-pane fade in one " id="desc">
									content
									</div>
								<div class="tab-pane fade in one" id="more">
									content
									</div>
							</div>
						</div>
                        
                     </div>
                    </div>
                   </div>
                 </div>
                 
         <div class="margin-bottom-80"></div>
                 
<div class="col-sm-6">
<div class="container-fluid">
 <div class="margin-bottom-80"></div>
 					
                   <div class="col-sm-8">
							<div class="tab-v2">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#spec2" data-toggle="tab">Specification</a></li>
							<li><a href="#desc2" data-toggle="tab">Description</a></li>
							<li><a href="#more2" data-toggle="tab">More Info</a></li>
						</ul>
                        </div>
                        
						<div class="col-sm-8">
                        <img class="img-center img-responsive img-circle"  src="content" alt="">
                        
                        <div class="margin-bottom-20"></div>
                        
							<div class=" tab-pane tab-content">
								<div class="tab-pane fade in active one" id="spec2">
								<p class="text-center img-center img-responsive">content</p>
							</div>
								<div class="tab-pane fade in one " id="desc2">
									<p class="text-center img-center img-responsive">content </p>
									</div>
								<div class="tab-pane fade in one" id="more2">
									<p class="text-center img-center img-responsive"> content</p>
									</div>
							</div>
						</div>
                        
                     </div>
                    </div>
                   </div>
                 </div>
@endsection