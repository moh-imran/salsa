<!DOCTYPE html>
<html>
<body>

<form method="post" action="{{url('school-comparison')}}">
    {{csrf_field()}}
    School Ids:
    <input type="text" name="school_ids">

    <input type="submit" value="Submit">
</form>

</body>
</html>