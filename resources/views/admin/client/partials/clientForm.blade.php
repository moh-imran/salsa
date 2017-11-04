<link href="{{ asset('css/admin/bootstrap-datepicker.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('js/admin/bootstrap-datepicker.js') }}"></script>

<fieldset class="content-group">

                    <form class="loginform">

                        
                   
                       
                        <div class="alert alert-danger col-xs-6 col-md-offset-3" v-if="errors.length > 0">
                                <ul v-for="error in errors">
                                    
                                        <li>@{{error}} </li>                                 
                                </ul>
                            </div>
                       
                         
                        <div class="form-group col-xs-6 col-md-offset-3">
                            <label class="control-label col-md-3 control_label">Name</label>
                            <div class="col-md-9">
                              
                                 <input class="form-control input_control input_control_rounded" v-model="name" placeholder="" type="text" required>
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>
                        
                        <div class="form-group col-xs-6 col-md-offset-3">
                            <label class="control-label col-md-3 control_label">Email</label>
                            <div class="col-md-9">
                                 <input class="form-control input_control input_control_rounded" v-model="email" name="email" placeholder="" type="text" required>
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>
                        
                        <div class="form-group col-xs-6 col-md-offset-3">
                            <label class="control-label col-md-3 control_label">Phone</label>
                            <div class="col-md-9">
                                <input class="form-control input_control input_control_rounded" v-model="phone" name="phone" placeholder="" type="text" required>
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>
                        
                        <div class="form-group col-xs-6 col-md-offset-3">
                            <label class="control-label col-md-3 control_label">No of Kids?</label>
                            <div class="col-md-9">
                                <table align="left" class="children_numbers">
                                <tbody><tr>
                                    <td></td>
                                    <td>
                                        <select v-model="selected" v-on:change="select_children" name="" id="no_children"  class="form-control input_control" style="border-radius:5px;">
                                            <option value="Select">Select</option>                                    
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody></table>
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>
                        
                            <div v-for="(n, index) in children" class="form-group col-xs-6 col-md-offset-3">
                                <div class="login_controls dynamic">
                                    <label class="control-label col-md-3 control_label">Age of Kid @{{index+1}}</label>
                                    <div class="col-md-9">
                            
                                        <div class="cross_container">
                                            <input :id="n.id" v-model="n.value" class="form-control input_control input_control_rounded" placeholder="Age of Kid" type="text">
                                            <a class="btn btn_cross" v-on:click="remove(index)">X</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        <div class="clearfix"></div>
                        <div class="form-group col-xs-6 col-md-offset-3 text-center">
                            <label class="control-label col-md-3">&nbsp;</label>
                            <div class="col-md-9">

                                <div class="cross_container">
                                    <button type="button" v-on:click="add_children_data()"  class="login btn btn-block btn_custom btn_reg">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
               
</fieldset>

<script>
 
 $(document).ready(function(){
        $('.date').datepicker({
                format: 'mm-dd-yyyy',
                startDate: new Date()
            });
            $('.date').on('changeDate', function(ev){
                $(this).datepicker('hide');
            });
        });
</script>        