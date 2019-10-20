/**
 * 登録
 * @param FollowEvent $event
 * @return bool
 * @throws \Illuminate\Database\Eloquent\MassAssignmentException
 */
public function execute(FollowEvent $event)
{
    try {
        DB::beginTransaction();

        $line_id = $event->getUserId();
        $rsp = $this->bot->getProfile($line_id);
        if (!$rsp->isSucceeded()) {
            logger()->info('failed to get profile. skip processing.');
            return false;
        }

        $profile = $rsp->getJSONDecodedBody();
        $line_friend = new LineFriend();
        $input = [
            'line_id' => $line_id,
            'display_name' => $profile['displayName'],
        ];

        $line_friend->fill($input)->save();
        DB::commit();

        return true;

    } catch (Exception $e) {
        logger()->error($e);
        DB::rollBack();
        return false;
    }
}
