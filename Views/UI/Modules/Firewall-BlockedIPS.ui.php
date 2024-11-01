<div class="wf-row">
	<div class="wf-col-xs-12">
		<div class="wf-block" data-persistence-key="waf-options-advanced">
			<div class="wf-block-header" style="cursor: pointer;">
				<div class="wf-block-header-content">
					<div class="wf-block-title">
						<strong>Blocked IP(s)</strong>
					</div>
					<div class="wf-block-header-action">
						<div class="wf-block-header-action-disclosure"></div>
					</div>
				</div>
			</div>
			<div class="wf-block-content" style="display: none;">
				<ul class="wf-block-list">
					<li>
            If You're under attack, Just write the Attacker's IP address and press Block!
					</li>

          <li class="wf-flex-horizontal wf-flex-vertical-xs wf-flex-full-width" style="border-top:none;">

              <div class="whitelist-table-container">
                  @include('Widgets.Feeds.BlockedIPS', ['required' => ''])

                <br>
              </div>

          </li>


				</div>
			</div>
		</div>
	</div>
</form>
