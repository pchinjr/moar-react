<div id="sidemenu-container" style="transition: 0.3s all;">
	<div class="main-wrap" style="max-width: calc(100% - 220px); margin: 0 auto;">
		<div class="row flex margin-bot-0">
			<div class="col s12 l12 m12 drafts-wrap content-wrap">
				<div class="main-drafts-wrap">
					<div class="create-draft">
						<div class="row">
							<div class="col s12">
								<a class="waves-effect waves-light btn green add-new add-new-draft">ADD NEW STORY</a>
							</div>
						</div>
					</div>
					<div class="manage-drafts">
						<?php 
							global $wpdb;
							
							$myrows = $wpdb->get_results( 'SELECT DISTINCT * FROM resume_entries WHERE ownerUserID = '.get_current_user_id().' ORDER BY entryID DESC' );
							//var_dump($myrows);
							for($i = 0; $i < sizeof($myrows); $i++)
							{
							  $entryID = $myrows[$i]->entryID;
							  $userID = $myrows[$i]->ownerUserID;
							  $expTitle = stripslashes($myrows[$i]->expTitle);
							  $expDescription = stripslashes($myrows[$i]->expDescription);
							  $expDate = stripslashes($myrows[$i]->expDate);
							  $skilltagsID = $myrows[$i]->skillTagsID;
							  $skillDescription = stripslashes($myrows[$i]->expDescription);
							  $expCategoryID = $myrows[$i]->expCategoryID;
							  $SkillsArr = explode(",", $skilltagsID);
							  $isDraft = $myrows[$i]->isDraft;
							  if(!empty($myrows[$i]->expImage))
							  {
							  	$imageURL = '/app/uploads/user_images/'.$myrows[$i]->expImage;
							  }
							  else
							  {
							  	$imageURL = "";
							  }
								echo '<div class="element-wrap">';
									echo '<div class="row draft-wrap" id="entryid-'.$entryID.'" data-entryid="'.$entryID.'">';
										echo '<div class="col s12 m12 l8">';
											echo '<div class="card-panel cp1 white">';
												echo '<div class="row row-1">';
													echo '<div class="input-field col s12">';
														echo '<input class="exp-title" placeholder="Write a title..." type="text" value="'.$expTitle.'">';
													echo '</div>';
												echo '</div>';
												echo '<div class="row row-2">';
													echo '<div class="input-field col s12 m12 l4">';
														$expDates=explode('_',$expDate);
														if (!isset($expDates[0]))$expDates[0]='';
														if (!isset($expDates[1]))$expDates[1]='';
                                                        echo '<input class="start-date" name="start-date" placeholder="Start date" type="text" value="'.$expDates[0].'">';
                                                        echo '<input class="end-date" name="end-date" placeholder="End date" type="text" value="'.$expDates[1].'">';
													echo '</div>';
												echo '</div>';
												echo '<div class="row row-3">';
													echo '<div class="input-field col s12 m12 l6">';
														echo '<select class="draft-categories" data-defaultcat="'.$expCategoryID.'">';
														  echo '<option value="" disabled selected>SELECT STORY CATEGORY</option>';
															$myrows0 = $wpdb->get_results( 'SELECT * FROM resume_cats' );
															for($k = 0; $k < sizeof($myrows0); $k++)
															{
															  echo '<option value="'. $myrows0[$k]->catID.'">'.$myrows0[$k]->catLabel.'</option>';
															}
														echo '</select>';
													echo '</div>';
												echo '</div>';
												echo '<div class="row row-4">';
													echo '<div class="col s12 add-skill-wrap cp1">';
														foreach ($SkillsArr as $singleSkill){
															$skillStuff = $wpdb->get_results('SELECT skillLabel from resume_skills WHERE resume_skills.skillID IN ('.$singleSkill.')');
															if(count($skillStuff)>0){
																echo '<a class="waves-effect btn btn-block1 waves-light btn-circle orange skillelem">'.$skillStuff[0]->skillLabel.'</a>';
															}
														}
														$hideAddSkill='';if (count($SkillsArr)>=4)$hideAddSkill='style="display:none;"';
														echo '<a class="waves-effect waves-light btn btn-block1 green btn-circle addSkillsdraft" '.$hideAddSkill.'>ADD SKILL +</a>';
														unset($hideAddSkill);
														echo '<select class="listskills" name="listskills">';
														
															$user = wp_get_current_user();
														    if ($user->isIB == '1') {
														      $myrows1 = $wpdb->get_results( 'SELECT * FROM resume_skills WHERE IsTypeIB = "1" ORDER BY skillLabel ASC' );
														    }else{
														      $myrows1 = $wpdb->get_results( 'SELECT * FROM resume_skills WHERE IsTypeIB <> "1" or IsTypeIB is null ORDER BY skillLabel ASC' );  
														    }
															for($j = 0; $j < sizeof($myrows1); $j++){
																echo '<option value="'.$myrows1[$j]->skillID.'" data-skillid='.$myrows1[$j]->skillID.'>'.$myrows1[$j]->skillLabel.'</option>';
															}
															
														echo '</select>';
													echo '</div>';
												echo '</div>';
												echo '<div class="row row-5">';
													echo '<div class="input-field col s12">';
														echo '<textarea class="exp-description materialize-textarea" placeholder="Tell us your story. What did you learn from this experience?" type="text" value="">'.$expDescription.'</textarea>';
														echo '<span class="input-count"></span>';
													echo '</div>';
												echo '</div>';
												echo '<div class="row row-6">';
													echo '<div class="col s12">';
														echo '<a href="#" class="post-btn blue-text preview-btn">PREVIEW</a>';
														echo '<a href="#" class="post-btn saveus-btn blue-text save-as-draft-btn">SAVE AS DRAFT</a>';
														echo '<a href="#" class="post-btn delete-btn red-text darken-1 delete-draft-btn">DELETE</a>';
														if($isDraft == "false"){echo '<span class="post-btn green-text" style="float: right;">PUBLISHED<i class="material-icons" style="vertical-align: bottom;">done</i></span>';}
													echo '</div>';
												echo '</div>';
											echo '</div>';
										echo '</div>';
										echo '<div class="col s12 m12 l4">';
											echo '<div class="card-panel cp2 white">';
												echo '<h6 class="black-text"><strong>Add a Photo (PNG/JPG, 1 MB Limit)</strong></h6>';
												echo '<a class="waves-effect waves-light btn green upload-image-btn">Upload Photo (.jpg or .png)</a>';
												echo '<input type="file" class="imageHolder" entryID="'.$entryID.'" id="imageHolder'.$entryID.'" style="display: none;" />';
												echo '<img src="'.$imageURL.'" id="imagePreview'.$entryID.'" style="margin-top: 10px; width: 100%;" />';
											echo '</div>';
										echo '</div>';
									echo '</div>'; ?>
									<div class="popup2">
										<div class="row">
											<div class="col s12 m12 l8">
												<div class="content-block white">
													<h5 class="black-text post-title"><strong>Your Title...</strong></h5>
													<span class="post-date"><strong>Your date</strong></span>
													<div class="row post-category-wrap" style="margin-bottom: 7px;">
														
													</div>
													<div class="row post-content">
														<p class="black-text">
															Your description.
														</p>
													</div>
												</div>
												<div class="info-block">
													<!--<a href="#" class="post-likes post-btn black-text"><i class="material-icons red-text">favorite</i> 26 LIKES</a>
													<a href="#" class="post-comments post-btn black-text"><i class="material-icons blue-text">comment</i> 10 COMMENTS</a>-->
													<?php if($isDraft == "true"){ ?>
														<a href="#" class="post-send-comment post-btn blue-text publish-btn">PUBLISH</a>
													<?php } else { ?>
														<a href="#" class="post-send-comment post-btn blue-text unpublish-btn">UNPUBLISH</a>
													<?php } ?>

													<a href="#" class="post-share post-btn red-text cancel-btn">CANCEL</a>
												</div>
											</div>
											<div class="col s12 m12 l4">
												<img id="previewEntryImage<?php echo $entryID ?>" class="responsive-img" src="<?php echo $imageURL ?>" alt="">
											</div>
										</div>
									</div>
								<?php echo '</div>';
							}
						?>
					</div>		
				</div>
			</div>
		</div>
	</div>
  </div>