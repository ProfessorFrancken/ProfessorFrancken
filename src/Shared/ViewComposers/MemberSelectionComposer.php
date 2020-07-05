<?php

declare(strict_types=1);

namespace Francken\Shared\ViewComposers;

use Illuminate\View\View;

final class MemberSelectionComposer
{
    private bool $composed_once = false;
    /**
     * Bind data to the view.
     */
    public function compose(View $view) : void
    {
        if ($this->composed_once === true) {
            return;
        }
        $this->composed_once = true;

        $members = \DB::connection('francken-legacy')
                ->table('leden')
                ->where('is_lid', true)
                ->select(['id',  'voornaam', 'tussenvoegsel', 'achternaam'])
                ->orderBy('id', 'desc')
                ->get();

        $view->with([
                'members' => $members
            ]);
        $factory = $view->getFactory();
        $factory->startPush(
                'css',
<<<'EOT'
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
EOT
            );
        $json_members = json_encode($members, JSON_THROW_ON_ERROR);
        $factory->startPush(
            'scripts',
            <<<EOT
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script type="text/javascript">
 $(document).ready(function () {
     var members = $json_members;
     var membersSource = members.map(function (member) {
         return {
             label: [member.voornaam, member.tussenvoegsel, member.achternaam].filter(function (val) { return val }).join(' '),
             id: member.id
         };
     });

     $('.member-selection').autocomplete({
         source: membersSource,
         select: function (event, ui) {
             document.getElementById(
                 event.target.getAttribute('data-target')
             ).value = ui.item.id;
         },
         minLength: 2
     });
 });
</script>
EOT
        );
        //  $factory->stopPush();
    }
}
