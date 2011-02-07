function check_path(path)
     local rv = path
     if (not file_info(path, "is_file")) then
        rv = nil
         local html_file = path .. ".html"
         if (file_info(html_file, "is_file")) then
             rv = html_file
         else
             -- handle directory indeces
             -- we first check if we have a dir and than look for an index.html
             local index_file = path .. "/index.html"
             if (file_info(path,"is_dir") and file_info(index_file, "is_file")) then
                 rv = index_file
             end
         end
     end
     if rv then
         lighty.env["physical.path"] = rv
     end
     return rv
end

function file_info(path, ftype)
    local attr = lighty.stat(path)
    if attr and attr[ftype] then
        return attr[ftype]
    end
    return false
    --return (attr and attr[ftype])
end

if (not (check_path(lighty.env["physical.path"]) or 
    (not lighty.request["Cookie"] and check_path(lighty.env["physical.doc-root"] .. 'cache/' .. lighty.request["Host"] .. "/" .. lighty.env["physical.rel-path"])))
    ) then
        lighty.env["uri.path"]          = "/index.php"
        lighty.env["uri.query"]         = "url=" .. string.gsub(lighty.env["request.uri"], "%?", "&")
        lighty.env["physical.rel-path"] = lighty.env["uri.path"]
        lighty.env["request.orig-uri"]  = lighty.env["request.uri"]
        lighty.env["physical.path"]     = lighty.env["physical.doc-root"] .. lighty.env["physical.rel-path"]
end