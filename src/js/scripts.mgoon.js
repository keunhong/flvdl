function mgoon_decode(mgoon_url){
	return mgoon_url.substring(0, mgoon_url.indexOf("?key=") + 5) + DecodeKey(mgoon_url.substring(mgoon_url.indexOf("?key=") + 5, mgoon_url.length));
}

function DecodeKey(EnKey){
        var _loc10 = 5;
        var _loc15 = 3;
        var _loc4 = 4;
        var _loc8 = new Array(5, 4, 2, 1, 3);
        var _loc7;
        var _loc3;
        var _loc6;
        var _loc9;
        var _loc5;
        var _loc2;
        var _loc13;
        var _loc11;
        var _loc14 = "";
        if (EnKey.indexOf("=") != -1)
        {
            _loc14 = EnKey.substring(EnKey.indexOf("="), EnKey.length);
        } // end if
        _loc13 = EnKey.substr(0, EnKey.length - _loc14.length);
        _loc7 = _loc13.length;
        _loc3 = Math.floor(_loc7 / _loc10);
        _loc6 = _loc7 - _loc3 * (_loc10 - 1);
        _loc9 = new Array(_loc10);
        _loc5 = this.ShuffleStr(_loc13, 0, _loc7 - _loc15, _loc7, _loc15);
        for (var _loc2 = 0; _loc2 < (_loc10 - 1) / 2; ++_loc2)
        {
            _loc5 = this.ShuffleStr(_loc5, _loc6 + _loc3 * _loc2 - (_loc4 - 1), _loc7 - _loc3 * (_loc2 + 1) - (_loc4 - 1), _loc7, _loc4);
        } // end of for
        for (var _loc2 = 0; _loc2 < _loc10; ++_loc2)
        {
            if (_loc2 == 0)
            {
                _loc9[_loc8[_loc2]] = _loc5.substring(_loc2 * _loc3, _loc6);
                continue;
            } // end if
            _loc9[_loc8[_loc2]] = _loc5.substring(_loc6 + (_loc2 - 1) * _loc3, _loc6 + _loc2 * _loc3);
        } // end of for
        _loc11 = "";
        for (var _loc2 = 1; _loc2 <= _loc10; ++_loc2)
        {
            _loc11 = _loc11 + _loc9[_loc2];
        } // end of for

		//document.write(_loc11 + _loc14);
		return (_loc11 + _loc14);
//		document.write(EnKey);
    } // End of the function
    function ShuffleStr(szInstr, nPosS, nPosE, nLen, nChar)
    {
        var _loc4;
        var _loc5;
        var _loc7;
        _loc5 = szInstr.substring(nPosS, nPosS + nChar);
        _loc7 = szInstr.substring(nPosE, nPosE + nChar);
        _loc4 = szInstr.substring(0, nPosS) + szInstr.substring(nPosE, nPosE + nChar) + szInstr.substring(nPosS + nChar, nLen);
        _loc4 = _loc4.substring(0, nPosE) + _loc5 + szInstr.substring(nPosE + nChar, nLen);
        return (_loc4);
} // End of the function