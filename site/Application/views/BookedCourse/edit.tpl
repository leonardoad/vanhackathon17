<div class="panel">
    <div class="panel-body">
        <input type="hidden" autofocus="true" />
        <!-- LINHA 1  -->
        <div class="row">
            <div class="col-lg-6">

                <div class="row">
                    <div class="col-lg-12">
                        {$ID_Course}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        {$ID_Company}
                    </div>

                </div>
                <!-- LINHA 4  -->
                <div class="row">
                    <div class="col-lg-6">
                        {$PretendDate}
                    </div>
                    <div class="col-lg-6">
                        {$RealDate}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        {$BundleFood}
                    </div>
                </div>
                <!-- LINHA 4  -->
                <div class="row">
                    <div class="col-lg-12">
                        {$DietaryRestriction}
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                {$btnNewReview}
                {$gridReview}
            </div>
        </div>
        <table width="100%">
            <tr>
                <td class="text-center"> {$btnSalvarBookedCourse} {$btnCancelarBookedCourse}  </td>
            </tr>
        </table>
    </div>
</div>