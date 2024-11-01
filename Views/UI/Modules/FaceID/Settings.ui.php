
@include('Layouts.Header', array("title" => 'Skytells FaceID', 'page' => 'faceid'))
<script type="text/javascript">
    function ResetOptions() {
        if (confirm("<?php _e('Are you sure you want to reset all options?', 'sfa-brute-force'); ?>")) {
            document.forms["reset_form"].submit();
        }
    }


</script>


            <div class="container-fluid">
              <div class="meta-box-sortabless">
      					<!-- Rebuild Area -->


      						<div class="card">
      							<div class="content">
      								<div class="row">
      									<!--  style="margin-bottom: -8px; padding-right: 5px;" -->
      									<div class="col-lg-2" style="width:5%;">
      										<img src="
      											<?= getSFAURL(); ?>/assets/images/fid.png"  style="" height="47px">
      										</div>
      										<div class="col-lg-10" style="width:95%;">
      											<h3 style="color: #3a88c9;    margin: 1px 0 2px; padding-left:0px;"> Skytells FaceID</h3>
                            <div >
          										<p>Skytells's AI-Powered Face ID lets you login with your Face!

          											<br>The Ultimate Protection for your website, Your Face is your Secured Password.


          											</p>
          										</div>
      										</div>
      									</div>
      									<!-- Image and text -->

      									</div>
      								</div>

      						</div>
<div class="wrap">


<form method="post" action="options.php">
  <?php settings_fields('sfa-faceid'); ?>

  <div class="row">
    <div class="col-xs-10">
      <div class="metabox-holder">
      	<div class="wf-block wp-active" data-persistence-key="waf-options-advanced">
      		<div class="wf-block-header" style="cursor: pointer;">
      			<div class="wf-block-header-content">
      				<div class="wf-block-title"> <strong><i class="ti-eye"></i> &nbsp; <?php _e('FaceID Settings', 'sfa-guard'); ?></strong>
      				</div>
      				<div class="wf-block-header-action">
      					<div class="wf-block-header-action-disclosure"></div>
      				</div>
      			</div>
      		</div>
      		<div class="wf-block-content" style="display: block;">
      			<ul class="wf-block-list">
              @if (!\Skytells\SFA::CL())
                <li style="min-height:70px; padding-top:10px;">

                      <div class="alert alert-warning">
                        <button type="button" aria-hidden="true" class="close">×</button>
                        <strong><b>Limited Access (Disabled Feature)</b></strong>
                          <span><b> Warning - </b> You're currently running on a FREE license while The FaceID Feature needs a Pro license to perform its own functions.</span>
                          <span>Please keep in mind that FaceID Syncing will not perform it's functionality on the FREE version.</span>
                          <span style="padding-top:4px;"><b><a href="<?=SFA_PRO_PURCHASE;?>" target="_blank">Click Here to Purchase A Pro License</a></b></span>
                  </div>
                </li>
              @else

              <li style="padding-top:10px;">
                <div class="col-md-12">
                  <div class="checkbox">
                   <input type="checkbox" id="SFA_FaceID" name="SFA_FaceID" value="true" <?php echo ($options['FaceID']) ? 'checked' : ''; ?>>
                   <label class="form-check-label" for="SFA_FaceID"><?php _e('Enable Skytells AI-Powered FaceID', 'sfa-guard'); ?>
                     <br><small class="form-text text-muted pl10">
                       <?php _e("If Enabled, Users Authenticating will be passed through Skytells's Latest AI", 'sfa-guard'); ?></small>
                   </label>
                  </div>
                </div>
              </li>


              <li style="padding-top:10px;">
                <div class="col-md-12">
                  <div class="checkbox">
                   <input type="checkbox" id="SFA_FaceID_AI" name="SFA_FaceID_AI" value="true" <?php echo ($options['FaceID_AI']) ? 'checked' : ''; ?>>
                   <label class="form-check-label" for="SFA_FaceID_AI"><?php _e("Use Skytells's Enhanced Artificial Intelligence?", 'sfa-guard'); ?>
                     <br><small class="form-text text-muted pl10">
                       <?php _e("If Enabled, Skytells AI will perform a deep scan of your Face which identifies your Age, Eyes Color, Hair, Gender, Emotions, Medical Issues, Skin Color Degrees, which improves the security for Anti-Fool's Built-in system.", 'sfa-guard'); ?></small>
                   </label>
                  </div>
                </div>
              </li>

              <li style="padding-top:10px;">
                <div class="col-md-12">
                  <div class="checkbox">
                   <input type="checkbox" id="SFA_FaceID_Attention" name="SFA_FaceID_Attention" value="true" <?php echo ($options['FaceID_Attention']) ? 'checked' : ''; ?>>
                   <label class="form-check-label" for="SFA_FaceID_Attention"><?php _e("Require Attention to FaceID?", 'sfa-guard'); ?>
                     <br><small class="form-text text-muted pl10">
                       <?php _e("If Enabled, Skytells FaceID will require your attention to prevent others from unlocking your account while you not aware or sleep.", 'sfa-guard'); ?></small>
                   </label>
                  </div>
                </div>
              </li>


              <li style="padding-top:10px;">
                <div class="col-md-12">
                  <div class="checkbox">
                   <input type="checkbox" id="SFA_FaceID_Auto" name="SFA_FaceID_Auto" value="true" <?php echo ($options['FaceID_Auto']) ? 'checked' : ''; ?>>
                   <label class="form-check-label" for="SFA_FaceID_Auto"><?php _e('Enable Automatic Detection', 'sfa-guard'); ?>
                     <br><small class="form-text text-muted pl10">
                       <?php _e("If Enabled, Face ID will start performing its functionality once your face appears on camera", 'sfa-guard'); ?></small>
                   </label>
                  </div>
                </div>
              </li>


              <li style="padding-top:10px;">
                <div class="col-md-12">
                  <div class="checkbox">
                   <input type="checkbox" id="SFA_FaceID_Limitation" name="SFA_FaceID_Limitation" value="true" <?php echo ($options['FaceID_Limitation']) ? 'checked' : ''; ?>>
                   <label class="form-check-label" for="SFA_FaceID_Limitation"><?php _e('Set Wrong Face-ID Failures Limit?', 'sfa-guard'); ?>
                     <br><small class="form-text text-muted pl10">
                       <?php _e("If Enabled, The IP Address of the user who tries to access your account with wrong face will be blocked after a specified tries.", 'sfa-guard'); ?></small>
                   </label>
                  </div>
                </div>
              </li>


              <li style="padding-top:10px;">
                <div class="col-md-12">
                  <div class="checkbox">
                   <input type="checkbox" id="SFA_Revoke_Session" name="SFA_FaceID_Revoke_Session" value="true" <?php echo ($options['FaceID_Revoke_Session']) ? 'checked' : ''; ?>>
                   <label class="form-check-label" for="SFA_Revoke_Session"><?php _e('Force Logout Unrecognized Faces?', 'sfa-guard'); ?>
                     <br><small class="form-text text-muted pl10">
                       <?php _e("If Enabled, The FaceID will force logout unrecognized faces when attempt to login!", 'sfa-guard'); ?></small>
                   </label>
                  </div>
                </div>
              </li>


              <li style="padding-top:10px;">
                <div class="col-md-12">
                  <div class="checkbox">
                   <input type="checkbox" id="SFA_FaceID_FrontendAllowed" name="SFA_FaceID_FrontendAllowed" value="true" <?php echo ($options['FaceID_FrontendAllowed']) ? 'checked' : ''; ?>>
                   <label class="form-check-label" for="SFA_FaceID_FrontendAllowed"><?php _e('Allow Unauthenticated users to access Frontend side?', 'sfa-guard'); ?>
                     <br><small class="form-text text-muted pl10">
                       <?php _e("If Enabled, Users who failed to bypass FaceID security layer will have access to the frontend side.", 'sfa-guard'); ?></small>
                   </label>
                  </div>
                </div>
              </li>


              <li style="min-height:50px; padding:10px;">
                <div class="col-md-6">
        					<div>
        						<label class="form-check-label" for="SFA_Skytells_API_KEY">
        							<?php _e( 'Skytells API Key', 'sfa-guard'); ?>
                      <br>
        						 <small class="form-text text-muted">
                             <?php _e('The Skytells API key used for authenticate your account with Skytells Guard. <a href="https://developers.skytells.net/OAuth/" target="_blank">Get API Key</a>', 'sfa-guard'); ?>
                    </small>
                    </label>
        					</div>
        				</div>
                <div class="col-md-6">
                  <input type="text" class="form-control" id="SFA_Skytells_API_KEY" name="SFA_Skytells_API_KEY" value="<?php echo $options['Skytells_API_KEY']; ?>">
                </div>
              </li>


              <li style="min-height:50px; padding:10px;">
                <div class="col-md-6">
        					<div>
        						<label class="form-check-label" for="SFA_FaceID_Timer">
        							<?php _e( 'Recognizer Wait Time', 'sfa-guard'); ?>
                      <br>
        						 <small class="form-text text-muted">
                             <?php _e('How many seconds should we let face id waits until you get ready on camera? (In Seconds) ', 'sfa-guard'); ?>
                    </small>
                    </label>
        					</div>
        				</div>
                <div class="col-md-6">
                  <input type="number" class="form-control" id="SFA_FaceID_Timer" min="3" max="20" name="SFA_FaceID_Timer" value="<?php echo (empty($options['FaceID_Timer'])) ? 5 : $options['FaceID_Timer']; ?>">
                </div>
              </li>


              <li style="min-height:50px; padding:10px;">
                <div class="col-md-6">
        					<div>
        						<label class="form-check-label" for="SFA_FaceID_Timer">
        							<?php _e( 'Maximum Failure Tries', 'sfa-guard'); ?>
                      <br>
        						 <small class="form-text text-muted">
                             <?php _e('If you enabled The Failures Limit option, Then How many tries should we allow in minutes for the IP Address? After these num of tries the IP address will get blocked if it reached the maximum failure limit ', 'sfa-guard'); ?>
                    </small>
                    </label>
        					</div>
        				</div>
                <div class="col-md-6">
                  <input type="number" class="form-control" id="SFA_FaceID_MaxTries" min="1" max="20" name="SFA_FaceID_MaxTries" value="<?php echo $options['FaceID_MaxTries']; ?>">
                </div>
              </li>


              <li style="min-height:50px; padding:10px;">
                <div class="col-md-6">
        					<div>
        						<label class="form-check-label" for="SFA_Revoke_Session_Attempts">
        							<?php _e( 'How many tries allowed before force logout?', 'sfa-guard'); ?>
                      <br>
        						 <small class="form-text text-muted">
                             <?php _e('If you enabled The Force Logout option, Then How many tries should we allow before force logout the user', 'sfa-guard'); ?>
                    </small>
                    </label>
        					</div>
        				</div>
                <div class="col-md-6">
                  <input type="number" class="form-control" id="SFA_Revoke_Session_Attempts" min="1" max="20" name="SFA_FaceID_Revoke_Session_Attempts" value="<?php echo $options['FaceID_Revoke_Session_Attempts']; ?>">
                </div>
              </li>



              @if (!(bool)$User['faceid_enrolled'])
              <li style="">
               <div class="form-row">
                <h5 class="panel-h5">SETUP</h5>
                <br>

                <div class="col-md-12">

                    <div class="alert alert-warning" style="    background-color: #fff7de!important;">
                      <button type="button" aria-hidden="true" class="close">×</button>
                      <strong style="margin-bottom:6px;"><b>Face ID is Not Ready Yet!</b></strong>
                        <span style="padding-top:4px;"><b> Warning - </b> Face ID is currently not setup, Please train Face ID to recognize your face!</span>
                        <span style="padding-top:1px;">You must train Skytells FaceID to recognize your face to enable it for this account.</span><br>

                            <span style="padding-top:4px;"><a href="#" class="js_faceid_enroll btn btn-md btn-success" style="background-color: #7AC29A; color: #fff; border-color: #7AC29A;" data-token="{{md5('faceid')}}"><b>Train FaceID</b></a></span>
                    </div>
                 </div>

              </div>
              </li>
              @endif


              @if ((bool)$User['faceid_enrolled'])
              <li style="min-height:50px; padding:10px;">


                <div class="col-md-8">
                  <p><i class="fa fa-check text-success"></i> Face ID can recognize your face!</p>
                </div>
                <div class="col-md-4">
                  <a href="#" class="js_faceid_enroll btn btn-sm btn-success" style="" data-token="{{md5('faceid')}}"><b>Re Train FaceID</b></a>

                 </div>


              </li>
              @endif





              <li>
              <div class="postbox-footer" style="">
                <?php submit_button(__( 'Save', 'sfa-settings'), 'primary', 'submit', false); ?>&nbsp;
                <a href="javascript:ResetOptions()" class="button">
                  <?php _e( 'Reset', 'sfa-guard'); ?>
                </a>
              </div>
            </li>
              @endif
            </ul>
      		</div>
      	</div>
      </div>



    </div>
    <div class="col-xs-2" style="padding:0px;">
      <div class="metabox-holder">
      <div class="wf-block wf-active" data-persistence-key="waf-options-advanced">
  			<div class="wf-block-header" style="cursor: pointer;">
  				<div class="wf-block-header-content">
  					<div class="wf-block-title">
  						<strong>{{__("Security News")}}</strong>
  					</div>
  					<div class="wf-block-header-action">
  						<div class="wf-block-header-action-disclosure"></div>
  					</div>
  				</div>
  			</div>
  			<div class="wf-block-content" style="display: block;">
          <ul class="wf-block-list">
          <li style="padding-top:4px; padding-bottom:6px; min-height:60px;">
            <img style="max-width: 100%; width: 400px;" src="{{getSFAURL()}}/assets/images/skytells-wp.png">
          </li>
          @if (!empty($news->security) && $news != false)
            <? $i = 0; ?>
          @foreach ($news->security as $n)
          @if($i == 0)
            <li style="padding:4px; padding-left:10px; border:none;"><a href="{{$n->link}}" class="tippy" title="{{$n->title}}" target="_blank">{{$n->title}}</a></li>
          @else
            <li style="padding:4px; padding-left:10px;"><a href="{{$n->link}}" class="tippy" title="{{$n->title}}" target="_blank">{{$n->title}}</a></li>
          @endif
          <? $i++; ?>
          @endforeach
          @else
            <li>There is no news at the moment!</li>
          @endif
        </ul>
        </div>
      </div>
      </div>





      <div class="metabox-holder">
      <div class="wf-block wf-active" data-persistence-key="waf-options-advanced">
  			<div class="wf-block-header" style="cursor: pointer;">
  				<div class="wf-block-header-content">
  					<div class="wf-block-title">
  						<strong>{{__("Face ID")}}</strong>
  					</div>
  					<div class="wf-block-header-action">
  						<div class="wf-block-header-action-disclosure"></div>
  					</div>
  				</div>
  			</div>
  			<div class="wf-block-content" style="display: block;">
          <ul class="wf-block-list">
          <li style="padding-top:4px; padding-bottom:6px; min-height:60px;">
          <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/BrIY-h8NfGc?rel=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
          </li>

        </ul>
        </div>
      </div>
      </div>
    </div>
  </div>




  </form>
  <form id="reset_form" method="post" action="">
      <input type="hidden" name="reset" value="true" />
  </form>
</div>
</div>
<br>
@include('Layouts.Footer')
