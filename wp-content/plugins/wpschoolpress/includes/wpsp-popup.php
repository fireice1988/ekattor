<!-- Start Data Success Popup -->
<div class="wpsp-popupMain wpsp-popVisible" id="SuccessModal" style="display:none;">
	<div class="wpsp-overlayer"></div> 
	<div class="wpsp-popBody wpsp-alert-body"> 
		<div class="wpsp-popInner">
			<a href="javascript:;" class="wpsp-closePopup"></a>
			<div class="wpsp-popup-cont wpsp-alertbox wpsp-alert-success">
				<div class="wpsp-alert-icon-box"> 
					<!-- <i class="icon wpsp-icon-tick-mark"></i> -->
					<i class="icon dashicons dashicons-yes"></i>
				</div>
				<div class="wpsp-alert-data">
					<input type="hidden" name="teacherid" id="teacherid">
					<h4>Success</h4>
					<p>Data Saved Successfully.</p>
				</div>
				
			</div>
		</div>
	</div>
</div>
<!-- End Data Save Popup -->
<!-- Start Data Saving Popup -->
<div class="wpsp-preLoading-onsubmit" id="SavingModal" style="display:none;">
   <div class="wpsp-loading_shape-onsubmit">
     <a href="javascript:;" class="wpsp-closeLoading"></a>
     <div class="wpsp-loader-onsubmit"></div>
     <p class="wpsp-saving-text">Saving data...</p>
   </div>
</div>
<!-- End Data Saving Popup -->
<!-- Start Data Warning Popup -->
<div class="wpsp-popupMain wpsp-popVisible" id="WarningModal" data-pop="WarningModal" style="display:none;">
  <div class="wpsp-overlayer"></div> 
  <div class="wpsp-popBody wpsp-alert-body"> 
	<div class="wpsp-popInner">
		<a href="javascript:;" class="wpsp-closePopup"></a>
		<div class="wpsp-popup-cont wpsp-alertbox wpsp-alert-warning">
			<div class="wpsp-alert-icon-box"> 
				<i class="icon wpsp-icon-question-mark"></i>
			</div>
			<div class="wpsp-alert-data">
				<h4>Warning</h4>
				<p class="wpsp-popup-return-data">Something went wrong!</p>
			</div>
			<div class="wpsp-alert-btn">
				<button type="submit" class="wpsp-btn wpsp-dark-btn wpsp-popup-cancel">Cancel</button>
			</div>
		</div>
	</div>
  </div>
</div> 
<!-- End Data Warning Popup -->
<!-- Start Data Delete Popup -->
<div class="wpsp-popupMain wpsp-popVisible" id="DeleteModal" data-pop="DeleteModal" style="display:none;">
  <div class="wpsp-overlayer"></div> 
  <div class="wpsp-popBody wpsp-alert-body"> 
	<div class="wpsp-popInner">
		<a href="javascript:;" class="wpsp-closePopup"></a>
		<div class="wpsp-popup-cont wpsp-alertbox wpsp-alert-danger">
			<div class="wpsp-alert-icon-box"> 
				<i class="icon wpsp-icon-question-mark"></i>
			</div>
			<div class="wpsp-alert-data">
				<h4>Confirmation Needed</h4>
				<p>Are you sure want to delete?</p>
			</div>
			<div class="wpsp-alert-btn">
				<input type="hidden" name="teacherid" id="teacherid">
				<a class="wpsp-btn wpsp-btn-danger ClassDeleteBt">Ok</a>
				<a href="javascript:;" class="wpsp-btn wpsp-dark-btn wpsp-popup-cancel">Cancel</a>
			</div>
		</div>
	</div>
  </div>
</div>
<!-- End Data Delete Popup -->